#!/usr/bin/env python3
"""Regenerate database/seeders/data/girona_roster.json from the club Excel file."""
from __future__ import annotations

import json
import sys
from pathlib import Path

import pandas as pd

ROOT = Path(__file__).resolve().parents[1]
OUT = ROOT / "database/seeders/data/girona_roster.json"


def parse_players(xl: pd.ExcelFile, sheet: str, cat: str) -> list[dict]:
    df = pd.read_excel(xl, sheet_name=sheet, header=None)
    rows: list[dict] = []
    for i in range(len(df)):
        if i < 3:
            continue
        row = df.iloc[i]
        try:
            dossar = int(float(row.iloc[0]))
        except (ValueError, TypeError):
            continue
        nom, prenom, poste = row.iloc[1], row.iloc[2], row.iloc[3]
        if pd.isna(nom) or pd.isna(prenom):
            continue
        rows.append(
            {
                "dossar": dossar,
                "nom": str(nom).strip().upper(),
                "prenom": str(prenom).strip(),
                "poste": str(poste).strip().title() if pd.notna(poste) else "Inconnu",
                "categorie": cat,
            }
        )
    return rows


def main() -> int:
    if len(sys.argv) < 2:
        print("Usage: python export_girona_roster_from_xlsx.py path/to/BASE_DE_DONNEES_GIRONA_FC.xlsx")
        return 1
    path = Path(sys.argv[1])
    xl = pd.ExcelFile(path)
    categories = ["U13", "U15", "U17", "U19"]
    joueurs = parse_players(xl, "Liste U13", "U13") + parse_players(xl, "Liste U15", "U15")
    OUT.parent.mkdir(parents=True, exist_ok=True)
    OUT.write_text(
        json.dumps({"categories": categories, "joueurs": joueurs}, ensure_ascii=False, indent=2),
        encoding="utf-8",
    )
    print(f"Wrote {len(joueurs)} joueurs -> {OUT}")
    return 0


if __name__ == "__main__":
    raise SystemExit(main())
