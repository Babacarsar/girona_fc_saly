#!/usr/bin/env python3
"""Import roster + sync player photos on production admin (requires admin login)."""
from __future__ import annotations

import os
import re
import sys

import requests

BASE = os.environ.get(
    "GIRONA_BASE_URL",
    "https://gironafcsaly-production-9141.up.railway.app",
)
EMAIL = os.environ["ADMIN_EMAIL"]
PASSWORD = os.environ["ADMIN_PASSWORD"]


def csrf(html: str) -> str:
    m = re.search(r'name="_token" value="([^"]+)"', html)
    if not m:
        raise RuntimeError("CSRF token not found")
    return m.group(1)


def post_action(session: requests.Session, path: str, confirm: str) -> None:
    dash = session.get(f"{BASE}/", timeout=60)
    dash.raise_for_status()
    r = session.post(
        f"{BASE}{path}",
        data={"_token": csrf(dash.text), "confirm": confirm},
        allow_redirects=False,
        timeout=300,
    )
    if r.status_code != 302:
        raise RuntimeError(f"POST {path} failed: {r.status_code} {r.text[:400]}")


def main() -> int:
    s = requests.Session()
    r = s.get(f"{BASE}/login", timeout=60)
    r.raise_for_status()
    s.post(
        f"{BASE}/login",
        data={"_token": csrf(r.text), "email": EMAIL, "password": PASSWORD},
        timeout=60,
    )
    home = s.get(f"{BASE}/", timeout=60)
    if "login" in home.url:
        print("Login failed — check ADMIN_EMAIL / ADMIN_PASSWORD")
        return 1

    post_action(s, "/admin/roster-import", "import")
    print("Roster import OK")

    post_action(s, "/admin/joueur-photos-sync", "photos")
    print("Photo sync OK")
    return 0


if __name__ == "__main__":
    sys.exit(main())
