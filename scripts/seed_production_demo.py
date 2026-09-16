#!/usr/bin/env python3
"""Trigger ClubDemoSeeder on production (requires admin login + deployed /admin/demo-seed)."""
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


def main() -> int:
    s = requests.Session()
    r = s.get(f"{BASE}/login", timeout=60)
    r.raise_for_status()
    s.post(
        f"{BASE}/login",
        data={"_token": csrf(r.text), "email": EMAIL, "password": PASSWORD},
        timeout=60,
    )
    dash = s.get(f"{BASE}/", timeout=60)
    r = s.post(
        f"{BASE}/admin/demo-seed",
        data={"_token": csrf(dash.text), "confirm": "demo"},
        allow_redirects=False,
        timeout=120,
    )
    if r.status_code == 302:
        print("ClubDemoSeeder OK")
        return 0
    print("Failed", r.status_code, r.text[:400])
    return 1


if __name__ == "__main__":
    sys.exit(main())
