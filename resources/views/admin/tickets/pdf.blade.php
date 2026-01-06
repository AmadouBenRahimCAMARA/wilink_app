<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Lot {{ $lot->numero_lot }}</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 10pt;
        }
        .ticket-container {
            width: 100%;
            /* Display grid not fully supported in DOMPDF, using inline-block or table */
        }
        .ticket {
            width: 45%; 
            display: inline-block;
            border: 1px dashed #333;
            margin: 5px;
            padding: 10px;
            page-break-inside: avoid;
            background-color: #f8f8f8;
        }
        .header {
            text-align: center;
            font-weight: bold;
            font-size: 12pt;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
            margin-bottom: 5px;
        }
        .code {
            font-size: 16pt;
            font-weight: bold;
            text-align: center;
            letter-spacing: 2px;
            margin: 10px 0;
            background-color: #fff;
            padding: 5px;
            border: 1px solid #eee;
        }
        .info {
            font-size: 9pt;
            color: #555;
            text-align: center;
        }
        .footer {
            font-size: 8pt;
            text-align: center;
            margin-top: 5px;
            color: #777;
        }
    </style>
</head>
<body>
    <div style="text-align: center; margin-bottom: 20px;">
        <h2>Lot de Tickets: {{ $lot->numero_lot }}</h2>
        <p>Type: {{ $lot->type_ticket->nom }} | Quantité: {{ $lot->quantite }} | Date: {{ $lot->created_at->format('d/m/Y') }}</p>
    </div>

    <div class="ticket-container">
        @foreach($lot->tickets as $ticket)
            <div class="ticket">
                <div class="header">WIFI ACCESS</div>
                <div class="info">
                    Utilisation: <strong>{{ $lot->type_ticket->nom }}</strong>
                </div>
                <div class="code">
                    {{ $ticket->code }}
                </div>
                <div class="footer">
                    Valide: {{ $lot->type_ticket->duree_minutes }} min
                    @if($lot->type_ticket->limite_data_mo)
                        | Data: {{ $lot->type_ticket->limite_data_mo }} Mo
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</body>
</html>
