<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>ใบเสร็จรับเงิน - {{ $receipt->document_number }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', 'Garuda', 'Arial', sans-serif;
            font-size: 12pt;
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
            color: #059669;
            text-align: right;
        }
        .doc-number {
            font-size: 14pt;
            text-align: right;
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
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .payment-box {
            background-color: #f0fdf4;
            border: 2px solid #059669;
            padding: 20px;
            margin: 30px 0;
            text-align: center;
        }
        .payment-label {
            font-size: 14pt;
            color: #666;
            margin-bottom: 10px;
        }
        .payment-amount {
            font-size: 32pt;
            font-weight: bold;
            color: #059669;
        }
        .payment-details {
            background-color: #f9fafb;
            padding: 20px;
            margin: 20px 0;
            border: 1px solid #e5e7eb;
        }
        .payment-details table {
            width: 100%;
        }
        .payment-details td {
            padding: 8px;
        }
        .qr-section {
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
                    <div class="doc-title">ใบเสร็จรับเงิน</div>
                    <div class="doc-number">{{ $receipt->document_number }}</div>
                </td>
            </tr>
        </table>
    </div>

    <!-- Customer & Details -->
    <table class="info-section">
        <tr>
            <td style="width: 50%; vertical-align: top;">
                <div class="info-title">ลูกค้า:</div>
                <div><strong>{{ $receipt->customer->name }}</strong></div>
                @if($receipt->customer->address)
                    <div style="font-size: 12pt;">{{ $receipt->customer->address }}</div>
                @endif
                @if($receipt->customer->phone)
                    <div style="font-size: 12pt;">โทร: {{ $receipt->customer->phone }}</div>
                @endif
                @if($receipt->customer->email)
                    <div style="font-size: 12pt;">อีเมล: {{ $receipt->customer->email }}</div>
                @endif
                @if($receipt->customer->tax_id)
                    <div style="font-size: 12pt;">เลขผู้เสียภาษี: {{ $receipt->customer->tax_id }}</div>
                @endif
            </td>
            <td style="width: 50%; vertical-align: top; text-align: right;">
                <div><strong>วันที่ออก:</strong> {{ $receipt->issue_date->format('d/m/Y') }}</div>
                @if($receipt->invoice)
                    <div><strong>ใบแจ้งหนี้:</strong> {{ $receipt->invoice->document_number }}</div>
                @endif
            </td>
        </tr>
    </table>

    <!-- Payment Details -->
    <div class="payment-details">
        <div class="info-title">รายละเอียดการชำระเงิน:</div>
        <table>
            <tr>
                <td style="width: 40%;"><strong>ช่องทางชำระเงิน:</strong></td>
                <td style="width: 60%;">
                    @php
                        $paymentMethods = [
                            'cash' => 'เงินสด',
                            'transfer' => 'โอนเงิน',
                            'cheque' => 'เช็ค',
                            'credit_card' => 'บัตรเครดิต',
                            'promptpay' => 'พร้อมเพย์',
                        ];
                    @endphp
                    {{ $paymentMethods[$receipt->payment_method] ?? $receipt->payment_method }}
                </td>
            </tr>
            @if($receipt->payment_reference)
                <tr>
                    <td><strong>หมายเลขอ้างอิง:</strong></td>
                    <td>{{ $receipt->payment_reference }}</td>
                </tr>
            @endif
        </table>
    </div>

    <!-- Amount -->
    <div class="payment-box">
        <div class="payment-label">ยอดเงินที่ชำระ</div>
        <div class="payment-amount">฿{{ number_format($receipt->amount, 2) }}</div>
    </div>

    <!-- PromptPay QR Code (for reference) -->
    @if($shop->settings->promptpay_id && $receipt->payment_method === 'promptpay')
        <div class="qr-section">
            <div class="qr-title">ชำระผ่าน PromptPay</div>
            @php
                $qrCode = generatePromptPayQR($shop->settings->promptpay_id, $receipt->amount);
            @endphp
            <div style="margin: 15px 0;">
                <img src="{{ $qrCode }}" alt="PromptPay QR Code" style="width: 200px; height: 200px;">
            </div>
            @if($shop->settings->promptpay_name)
                <div style="font-size: 12pt;">{{ $shop->settings->promptpay_name }}</div>
            @endif
            <div style="font-size: 11pt; color: #666; margin-top: 5px;">
                QR Code นี้ใช้สำหรับอ้างอิงเท่านั้น
            </div>
        </div>
    @endif

    <!-- Notes -->
    @if($receipt->notes)
        <div class="notes-section">
            <div class="notes-title">หมายเหตุ:</div>
            <div class="notes-content">{{ $receipt->notes }}</div>
        </div>
    @endif
</body>
</html>
