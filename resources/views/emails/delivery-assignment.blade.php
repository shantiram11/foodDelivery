<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Ready for Delivery</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif;
            line-height: 1.6;
            color: #333333;
            background-color: #f5f5f5;
            padding: 20px 0;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border: 1px solid #e0e0e0;
        }

        .header {
            background-color: #2c3e50;
            color: white;
            padding: 30px;
            text-align: center;
        }

        .header h1 {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .header p {
            font-size: 16px;
            opacity: 0.9;
        }

        .content {
            padding: 30px;
        }

        .greeting {
            font-size: 18px;
            color: #333;
            margin-bottom: 20px;
            font-weight: 500;
        }

        .message {
            font-size: 16px;
            color: #666;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .section {
            margin-bottom: 25px;
        }

        .section-title {
            font-size: 16px;
            font-weight: 600;
            color: #333;
            margin-bottom: 15px;
            padding-bottom: 8px;
            border-bottom: 2px solid #e0e0e0;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-label {
            color: #666;
            font-size: 14px;
            font-weight: 500;
        }

        .detail-value {
            color: #333;
            font-size: 14px;
            font-weight: 600;
        }

        .delivery-section {
            background-color: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 6px;
            padding: 20px;
            margin-bottom: 25px;
        }

        .eta-highlight {
            background-color: #34495e;
            color: white;
            padding: 4px 12px;
            border-radius: 4px;
            font-weight: 600;
            font-size: 14px;
        }

        .status-badge {
            background-color: #27ae60;
            color: white;
            padding: 4px 10px;
            border-radius: 4px;
            font-weight: 500;
            font-size: 13px;
        }

        .footer {
            background-color: #f8f9fa;
            padding: 25px;
            text-align: center;
            border-top: 1px solid #e0e0e0;
        }

        .footer p {
            color: #666;
            font-size: 14px;
            margin-bottom: 8px;
        }

        .footer p:last-child {
            margin-bottom: 0;
            color: #999;
            font-size: 13px;
        }

        @media (max-width: 600px) {
            body {
                padding: 10px 0;
            }

            .container {
                margin: 0 10px;
                border-radius: 6px;
            }

            .header, .content, .footer {
                padding: 20px;
            }

            .header h1 {
                font-size: 20px;
            }

            .detail-row {
                flex-direction: column;
                align-items: flex-start;
                gap: 4px;
            }

            .detail-value {
                text-align: left;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Order Ready for Delivery</h1>
            <p>Your order is on its way to you</p>
        </div>

        <div class="content">
            <div class="greeting">
                Hello,  <strong>{{ $order->user->name }}</strong>,
            </div>

            <div class="message">
                Good news! Your order has been prepared and assigned to a delivery staff member. It will be delivered to you shortly.
            </div>

            <div class="section">
                <div class="section-title">Order Details</div>
                <div class="detail-row">
                    <span class="detail-label">Order Number :</span>
                    <span class="detail-value">{{ $order->order_number }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Restaurant :</span>
                    <span class="detail-value">{{ $order->restaurant->name }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Total Amount :</span>
                    <span class="detail-value">RS.{{ number_format($order->total_amount, 2) }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Order Date :</span>
                    <span class="detail-value">{{ $order->created_at->format('M j, Y') }}</span>
                </div>
            </div>

            <div class="delivery-section">
                <div class="section-title">Delivery Information</div>
                <div class="detail-row">
                    <span class="detail-label">Delivery Staff :</span>
                    <span class="detail-value">{{ $deliveryStaff->name }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Estimated Time</span>
                    <span class="detail-value">30 min</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Status</span>
                    <span class="detail-value">Out for delivery</span>
                </div>
            </div>

            <div class="message">
                Your order will be delivered to your address. The delivery staff will contact you upon arrival.
            </div>
        </div>

        <div class="footer">
            <p>Thank you for choosing our food delivery service!</p>
            <p>If you have any questions, please contact our support team.</p>
            <p>© {{ date('Y') }} Food Delivery Service</p>
        </div>
    </div>
</body>
</html>