<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Lfd. Nr.</th>
            <th>BUE ID</th>
            <th>Itexia ID</th>
            <th>Gültig ab</th>
            <th>Gültig bis</th>
            <th>Kurzzeichen</th>
            <th>Druckbezeichnung</th>
            <th>Raumnummer (Alt)</th>
            <th>Gebäude</th>
            <th>Gebäude Extern</th>
            <th>Plätze</th>
            <th>Plätze FF</th>
            <th>Quadratmeter</th>
            <th>Straße</th>
            <th>PLZ</th>
            <th>Ort</th>
            <th>Raumnummer (Neu)</th>
            <th>Vorgänger Raumnummer</th>
            <th>Nachfolger Raumnummer</th>
            <th>Fachbereich</th>
            <th>HPI Lfd. Nr.</th>
            <th>HPI Anzahl Einheiten</th>
            <th>Bemerkung</th>
            <th>Einheit gültig ab</th>
            <th>Einheit gültig bis</th>
            <th>Etage</th>
            <th>Pri/Sek</th>
            <th>Nutzungsart</th>
            <th>Standort</th>
            <th>Erstellt am</th>
            <th>Aktualisiert am</th>
        </tr>
    </thead>
    <tbody>
        @foreach($raume as $raum)
            <tr>
                <td>{{ $raum->id }}</td>
                <td>{{ $raum->lfd_nr }}</td>
                <td>{{ $raum->bue_id }}</td>
                <td>{{ $raum->itexia_id }}</td>
                <td>{{ $raum->gueltig_ab?->format('d.m.Y') }}</td>
                <td>{{ $raum->gueltig_bis?->format('d.m.Y') }}</td>
                <td>{{ $raum->kurzzeichen }}</td>
                <td>{{ $raum->druckbezeichnung }}</td>
                <td>{{ $raum->raumnummer }}</td>
                <td>{{ $raum->gebaeude?->bezeichnung }}</td>
                <td>{{ $raum->gebaeude_extern }}</td>
                <td>{{ $raum->plaetze }}</td>
                <td>{{ $raum->plaetze_ff }}</td>
                <td>{{ $raum->qm }}</td>
                <td>{{ $raum->strasse }}</td>
                <td>{{ $raum->plz }}</td>
                <td>{{ $raum->ort }}</td>
                <td>{{ $raum->raumnr_neu }}</td>
                <td>{{ $raum->raumnr_vorgaenger }}</td>
                <td>{{ $raum->raumnr_nachfolger }}</td>
                <td>{{ $raum->fachbereich?->bezeichnung }}</td>
                <td>{{ $raum->hpi_lfd_nr }}</td>
                <td>{{ $raum->hpi_anzahl_einheiten }}</td>
                <td>{{ $raum->bemerkung }}</td>
                <td>{{ $raum->einheit_gueltig_ab?->format('d.m.Y') }}</td>
                <td>{{ $raum->einheit_gueltig_bis?->format('d.m.Y') }}</td>
                <td>{{ $raum->etage?->bezeichnung }}</td>
                <td>{{ $raum->pri_sek?->name }}</td>
                <td>{{ $raum->nutzungsart?->bezeichnung }}</td>
                <td>{{ $raum->gebaeude?->standort?->kurz }}</td>
                <td>{{ $raum->created_at?->format('d.m.Y H:i:s') }}</td>
                <td>{{ $raum->updated_at?->format('d.m.Y H:i:s') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

