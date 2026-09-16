#!/usr/bin/env python3
"""Populate Railway demo data via admin session (no Cloudinary required when photo_url is deployed)."""
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

IMG = {
    "football": "https://images.unsplash.com/photo-1574623452339-4fdf6922d2f1?w=800&q=80",
    "stadium": "https://images.unsplash.com/photo-1459865274687-595d652de67e?w=800&q=80",
    "team": "https://images.unsplash.com/photo-1522778119026-d647f0565c6b?w=800&q=80",
    "training": "https://images.unsplash.com/photo-1579952363873-27f3bade9f55?w=800&q=80",
    "ball": "https://images.unsplash.com/photo-1431324155629-1a6deb1dec8d?w=800&q=80",
    "youth": "https://images.unsplash.com/photo-1517466787929-bc90951f0977?w=800&q=80",
}


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

    # Prefer one-click seeder when deployed
    dash = s.get(f"{BASE}/", timeout=60)
    if "admin/demo-seed" in dash.text or True:
        r = s.post(
            f"{BASE}/admin/demo-seed",
            data={"_token": csrf(dash.text), "confirm": "demo"},
            allow_redirects=False,
            timeout=120,
        )
        if r.status_code == 302:
            print("ClubDemoSeeder triggered via admin.")
            return 0
        if r.status_code != 404:
            print("demo-seed response", r.status_code, r.text[:300])

    print("demo-seed route not available yet; run again after deploy.")
    return 1


if __name__ == "__main__":
    sys.exit(main())
