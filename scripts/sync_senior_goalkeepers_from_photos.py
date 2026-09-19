#!/usr/bin/env python3
"""Merge Senior goalkeepers from G-*.jpg filenames into girona_roster.json."""
from __future__ import annotations

import json
import re
from pathlib import Path

ROOT = Path(__file__).resolve().parents[1]
PHOTOS_DIR = ROOT / "database/seeders/data/joueur_photos/Senior"
ROSTER_PATH = ROOT / "database/seeders/data/girona_roster.json"
SENIOR_CATEGORY = "Senior"


def parse_goalkeeper_filename(name: str) -> tuple[str, str] | None:
    stem = Path(name).stem
    match = re.match(r"^G-(.+)$", stem, re.IGNORECASE)
    if not match:
        return None
    parts = [p for p in match.group(1).split("-") if p]
    if len(parts) < 2:
        return None
    nom = parts[-1].upper()
    prenom = " ".join(p.title() for p in parts[:-1])
    return prenom, nom


def main() -> int:
    if not PHOTOS_DIR.is_dir():
        print(f"No photo directory: {PHOTOS_DIR}")
        return 1

    payload = json.loads(ROSTER_PATH.read_text(encoding="utf-8"))
    categories: list[str] = payload.get("categories") or []
    if SENIOR_CATEGORY not in categories:
        categories.append(SENIOR_CATEGORY)

    joueurs: list[dict] = payload.get("joueurs") or []
    joueurs = [j for j in joueurs if j.get("categorie") != SENIOR_CATEGORY]

    added = 0
    for path in sorted(PHOTOS_DIR.glob("G-*")):
        if path.suffix.lower() not in {".jpg", ".jpeg", ".png", ".webp"}:
            continue
        parsed = parse_goalkeeper_filename(path.name)
        if not parsed:
            continue
        prenom, nom = parsed
        joueurs.append(
            {
                "nom": nom,
                "prenom": prenom,
                "poste": "Gardien",
                "categorie": SENIOR_CATEGORY,
                "photo_file": path.name,
            }
        )
        added += 1

    payload["categories"] = categories
    payload["joueurs"] = joueurs
    ROSTER_PATH.write_text(
        json.dumps(payload, ensure_ascii=False, indent=2) + "\n",
        encoding="utf-8",
    )
    print(f"Senior goalkeepers synced: {added} (from {PHOTOS_DIR})")
    return 0


if __name__ == "__main__":
    raise SystemExit(main())
