<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>ใบแจ้งหนี้ - {{ $invoice->document_number }}</title>
    <style>
        body {
            font-family: 'freeserif', 'DejaVu Sans', sans-serif;
            font-size: 14pt;
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
        .text-center {
            text-align: center;
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
        .payment-info {
            color: #059669;
        }
        .remaining-info {
            color: #dc2626;
        }
        .qr-section {
            clear: both;
            margin-top: 30px;
            padding: 20px;
            background-color: #f0f9ff;
            border: 1px solid #bae6fd;
            text-align: center;
        }
        .qr-title {
            font-size: 16pt;
            font-weight: bold;
            margin-bottom: 10px;
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
                    <div class="doc-title">ใบแจ้งหนี้</div>
                    <div class="doc-number">{{ $invoice->document_number }}</div>
                    @php
                        $statusColors = [
                            'draft' => 'background-color: #f3f4f6; color: #374151;',
                            'sent' => 'background-color: #dbeafe; color: #1e40af;',
                            'partial' => 'background-color: #fef3c7; color: #92400e;',
                            'paid' => 'background-color: #d1fae5; color: #065f46;',
                            'overdue' => 'background-color: #fee2e2; color: #991b1b;',
                            'cancelled' => 'background-color: #f3f4f6; color: #374151;',
                        ];
                        $statusLabels = [
                            'draft' => 'ฉบับร่าง',
                            'sent' => 'ส่งแล้ว',
                            'partial' => 'ชำระบางส่วน',
                            'paid' => 'ชำระแล้ว',
                            'overdue' => 'เกินกำหนด',
                            'cancelled' => 'ยกเลิก',
                        ];
                    @endphp
                    <div class="text-right">
                        <span class="status-badge" style="{{ $statusColors[$invoice->status] ?? 'background-color: #f3f4f6; color: #374151;' }}">
                            {{ $statusLabels[$invoice->status] ?? $invoice->status }}
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
                <div><strong>{{ $invoice->customer->name }}</strong></div>
                @if($invoice->customer->address)
                    <div style="font-size: 12pt;">{{ $invoice->customer->address }}</div>
                @endif
                @if($invoice->customer->phone)
                    <div style="font-size: 12pt;">โทร: {{ $invoice->customer->phone }}</div>
                @endif
                @if($invoice->customer->email)
                    <div style="font-size: 12pt;">อีเมล: {{ $invoice->customer->email }}</div>
                @endif
                @if($invoice->customer->tax_id)
                    <div style="font-size: 12pt;">เลขผู้เสียภาษี: {{ $invoice->customer->tax_id }}</div>
                @endif
            </td>
            <td style="width: 50%; vertical-align: top; text-align: right;">
                <div><strong>วันที่ออก:</strong> {{ $invoice->issue_date->format('d/m/Y') }}</div>
                <div><strong>วันครบกำหนด:</strong> {{ $invoice->due_date->format('d/m/Y') }}</div>
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
            @foreach($invoice->items as $index => $item)
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
            <td class="text-right">฿{{ number_format($invoice->subtotal, 2) }}</td>
        </tr>
        @if($shop->settings->show_tax)
            <tr>
                <td class="total-label">ภาษี ({{ $shop->settings->tax_rate }}%):</td>
                <td class="text-right">฿{{ number_format($invoice->tax_amount, 2) }}</td>
            </tr>
        @endif
        <tr>
            <td class="total-label grand-total">รวมทั้งสิ้น:</td>
            <td class="text-right grand-total">฿{{ number_format($invoice->total, 2) }}</td>
        </tr>
        @if($invoice->paid_amount > 0)
            <tr>
                <td class="total-label payment-info">ชำระแล้ว:</td>
                <td class="text-right payment-info">฿{{ number_format($invoice->paid_amount, 2) }}</td>
            </tr>
            <tr>
                <td class="total-label remaining-info">คงเหลือ:</td>
                <td class="text-right remaining-info">฿{{ number_format($invoice->total - $invoice->paid_amount, 2) }}</td>
            </tr>
        @endif
    </table>

    <!-- PromptPay QR Code -->
    @if($shop->settings->promptpay_id && $invoice->status !== 'paid' && $invoice->status !== 'cancelled')
        <div class="qr-section">
            <div class="qr-title">ชำระเงินผ่าน PromptPay</div>
            @php
                $remainingAmount = $invoice->total - $invoice->paid_amount;
                $qrCode = generatePromptPayQR($shop->settings->promptpay_id, $remainingAmount);
            @endphp
            <div style="margin: 15px 0;">
                <img src="{{ $qrCode }}" alt="PromptPay QR Code" style="width: 200px; height: 200px;">
            </div>
            <div style="font-size: 12pt;">สแกน QR Code เพื่อชำระเงิน</div>
            @if($shop->settings->promptpay_name)
                <div style="font-size: 12pt;">{{ $shop->settings->promptpay_name }}</div>
            @endif
            <div style="font-size: 16pt; font-weight: bold; margin-top: 5px;">
                ฿{{ number_format($remainingAmount, 2) }}
            </div>
        </div>
    @endif

    <!-- Notes & Terms -->
    @if($invoice->notes || $invoice->terms)
        <div class="notes-section">
            @if($invoice->notes)
                <div style="margin-bottom: 15px;">
                    <div class="notes-title">หมายเหตุ:</div>
                    <div class="notes-content">{{ $invoice->notes }}</div>
                </div>
            @endif

            @if($invoice->terms)
                <div>
                    <div class="notes-title">เงื่อนไขการชำระเงิน:</div>
                    <div class="notes-content">{{ $invoice->terms }}</div>
                </div>
            @endif
        </div>
    @endif
</body>
</html>
