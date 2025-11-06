<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>ใบเสนอราคา - {{ $quotation->document_number }}</title>
    <style>
        body {
            font-family: 'THSarabunNew', 'Garuda', 'Norasi', sans-serif;
            font-size: 16pt;
            line-height: 1.6;
            color: #333;
        }
        .header {
            border-bottom: 3px solid {{ $shop->settings->primary_color ?? '#0ea5e9' }};
            padding-bottom: 20px;
            margin-bottom: 20px;
        }
        .header-table {
            width: 100%;
        }
        .shop-name {
            font-size: 24pt;
            font-weight: bold;
            color: {{ $shop->settings->primary_color ?? '#0ea5e9' }};
        }
        .shop-info {
            font-size: 12pt;
            color: #666;
            line-height: 1.4;
        }
        .doc-title {
            font-size: 20pt;
            font-weight: bold;
            color: {{ $shop->settings->primary_color ?? '#0ea5e9' }};
            text-align: right;
        }
        .doc-number {
            font-size: 14pt;
            text-align: right;
            margin-top: 5px;
        }
        .status-badge {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 15px;
            font-size: 11pt;
            font-weight: bold;
            margin-top: 5px;
        }
        .info-section {
            width: 100%;
            margin-bottom: 20px;
        }
        .info-title {
            font-weight: bold;
            font-size: 13pt;
            margin-bottom: 5px;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .items-table th {
            background-color: #f3f4f6;
            padding: 10px;
            text-align: left;
            font-weight: bold;
            border-bottom: 2px solid #ddd;
        }
        .items-table td {
            padding: 8px 10px;
            border-bottom: 1px solid #e5e7eb;
        }
        .text-right {
            text-align: right;
        }
        .totals-table {
            width: 50%;
            float: right;
            margin-top: 20px;
        }
        .totals-table td {
            padding: 8px;
        }
        .total-label {
            font-weight: bold;
        }
        .grand-total {
            font-size: 16pt;
            font-weight: bold;
            color: {{ $shop->settings->primary_color ?? '#0ea5e9' }};
            border-top: 2px solid #333;
            padding-top: 10px;
        }
        .notes-section {
            clear: both;
            margin-top: 30px;
            padding-top: 20px;
        }
        .notes-title {
            font-weight: bold;
            font-size: 13pt;
            margin-bottom: 5px;
        }
        .notes-content {
            font-size: 12pt;
            color: #666;
            white-space: pre-line;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <table class="header-table">
            <tr>
                <td style="width: 60%; vertical-align: top;">
                    <div class="shop-name">{{ $shop->name }}</div>
                    <div class="shop-info">
                        {{ $shop->address }}<br>
                        โทร: {{ $shop->phone }}
                        @if($shop->email)
                            <br>อีเมล: {{ $shop->email }}
                        @endif
                        @if($shop->tax_id)
                            <br>เลขผู้เสียภาษี: {{ $shop->tax_id }}
                        @endif
                    </div>
                </td>
                <td style="width: 40%; vertical-align: top;">
                    <div class="doc-title">ใบเสนอราคา</div>
                    <div class="doc-number">{{ $quotation->document_number }}</div>
                    @php
                        $statusColors = [
                            'draft' => 'background-color: #f3f4f6; color: #374151;',
                            'sent' => 'background-color: #dbeafe; color: #1e40af;',
                            'accepted' => 'background-color: #d1fae5; color: #065f46;',
                            'rejected' => 'background-color: #fee2e2; color: #991b1b;',
                        ];
                        $statusLabels = [
                            'draft' => 'ฉบับร่าง',
                            'sent' => 'ส่งแล้ว',
                            'accepted' => 'ยอมรับ',
                            'rejected' => 'ปฏิเสธ',
                        ];
                    @endphp
                    <div class="text-right">
                        <span class="status-badge" style="{{ $statusColors[$quotation->status] ?? 'background-color: #f3f4f6; color: #374151;' }}">
                            {{ $statusLabels[$quotation->status] ?? $quotation->status }}
                        </span>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <!-- Customer & Dates -->
    <table class="info-section">
        <tr>
            <td style="width: 50%; vertical-align: top;">
                <div class="info-title">ลูกค้า:</div>
                <div><strong>{{ $quotation->customer->name }}</strong></div>
                @if($quotation->customer->address)
                    <div style="font-size: 12pt;">{{ $quotation->customer->address }}</div>
                @endif
                @if($quotation->customer->phone)
                    <div style="font-size: 12pt;">โทร: {{ $quotation->customer->phone }}</div>
                @endif
                @if($quotation->customer->email)
                    <div style="font-size: 12pt;">อีเมล: {{ $quotation->customer->email }}</div>
                @endif
                @if($quotation->customer->tax_id)
                    <div style="font-size: 12pt;">เลขผู้เสียภาษี: {{ $quotation->customer->tax_id }}</div>
                @endif
            </td>
            <td style="width: 50%; vertical-align: top; text-align: right;">
                <div><strong>วันที่ออก:</strong> {{ $quotation->issue_date->format('d/m/Y') }}</div>
                <div><strong>วันหมดอายุ:</strong> {{ $quotation->valid_until->format('d/m/Y') }}</div>
            </td>
        </tr>
    </table>

    <!-- Items Table -->
    <table class="items-table">
        <thead>
            <tr>
                <th style="width: 5%;">#</th>
                <th style="width: 40%;">รายการ</th>
                <th style="width: 12%; text-align: right;">จำนวน</th>
                <th style="width: 15%; text-align: right;">ราคา/หน่วย</th>
                <th style="width: 13%; text-align: right;">ส่วนลด</th>
                <th style="width: 15%; text-align: right;">รวม</th>
            </tr>
        </thead>
        <tbody>
            @foreach($quotation->items as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->description }}</td>
                    <td class="text-right">{{ number_format($item->quantity, 2) }}</td>
                    <td class="text-right">฿{{ number_format($item->unit_price, 2) }}</td>
                    <td class="text-right">฿{{ number_format($item->discount, 2) }}</td>
                    <td class="text-right"><strong>฿{{ number_format($item->total, 2) }}</strong></td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Totals -->
    <table class="totals-table">
        <tr>
            <td class="total-label">ยอดรวม:</td>
            <td class="text-right">฿{{ number_format($quotation->subtotal, 2) }}</td>
        </tr>
        @if($shop->settings->show_tax)
            <tr>
                <td class="total-label">ภาษี ({{ $shop->settings->tax_rate }}%):</td>
                <td class="text-right">฿{{ number_format($quotation->tax_amount, 2) }}</td>
            </tr>
        @endif
        <tr>
            <td class="total-label grand-total">รวมทั้งสิ้น:</td>
            <td class="text-right grand-total">฿{{ number_format($quotation->total, 2) }}</td>
        </tr>
    </table>

    <!-- Notes & Terms -->
    @if($quotation->notes || $quotation->terms)
        <div class="notes-section">
            @if($quotation->notes)
                <div style="margin-bottom: 15px;">
                    <div class="notes-title">หมายเหตุ:</div>
                    <div class="notes-content">{{ $quotation->notes }}</div>
                </div>
            @endif

            @if($quotation->terms)
                <div>
                    <div class="notes-title">เงื่อนไขการชำระเงิน:</div>
                    <div class="notes-content">{{ $quotation->terms }}</div>
                </div>
            @endif
        </div>
    @endif
</body>
</html>
