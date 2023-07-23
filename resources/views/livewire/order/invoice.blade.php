<!DOCTYPE html>
<html lang="en">
<head>
    <title>Invoice</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        body {
            /* font-family: freeserif,sans-serif,vrinda,solaiman-lipi,monospace; */
            font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Helvetica,Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji";
            font-style: normal; font-variant: normal;
            font-size: 12px;
        }
        h1, h2, h3, h4, p, input, th, td{
            /* font-family: freeserif,sans-serif,vrinda,solaiman-lipi,monospace; */
            font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Helvetica,Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji";
            font-weight: 400;
            white-space: initial;
            font-style: normal; font-variant: normal;
            font-size: 12px;
        }
        .block{
            width: 100%;
            margin-bottom: 5px;
        }
        .card{
            width: 100%;
        }
    </style>
</head>
<body style="background: #FFFFFF">
<div style="max-width: 595px; margin-left: auto; margin-right: auto;">
    <table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
        <tr>
            <td style="text-align: center;">
                <div>
                    <img src="{{url('/')}}/assets/images/bof.png" alt="" height="67">
                </div>
            </td>
        </tr>
        <tr><td height="10"></td></tr>
        <tr valign="top">
            <td style="text-align: center;">
                <div style="font-weight: 450;font-size: 8px;letter-spacing: 0.02em;color: #000000;margin-right: 12px;">
                    <h2 style="font-size: 16px;font-weight: bold">Bangladesh Ordnance Factories ERP</h2>
                </div>
            </td>
        </tr>
        <tr><td height="35"></td></tr>
    </table>

    <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td width="30"></td>
            <td>
                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                    <tr> <td>Bill To </td> <td> </td> <td></td></tr>
                    <tr> <td>Customer Name</td> <td> : </td> <td> {{ $sales_order?->customer?->name }} </td></tr>
                    <tr> <td>Phone To </td> <td> : </td> <td>  {{ $sales_order?->customer?->phone }} </td></tr>
                </table>
            </td>
            <td width="200"></td>
            <td>
                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                    <tr> <td>Order info </td><td></td> <td> </td></tr>
                    <tr> <td>Order No </td> <td> : </td> <td> {{ $sales_order?->order_number }} </td></tr>
                    <tr> <td>Date </td><td> : </td> <td> {{ $sales_order?->order_date }} </td></tr>
                </table>
            </td>
        </tr>
        <tr><td height="35"></td></tr>
    </table>

    <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <thead>
        <tr>
            <th width="30"></th>
            <th width="100" style="border-bottom: 1px solid #000000; height: 30px;text-align: left;">
                <div style="font-weight: bold;font-size: 13px;letter-spacing: 0.02em;text-transform: uppercase;color: #000000; margin-bottom: 12px ; margin-left: 10px;">Product</div>
            </th>
            <th width="30" style="border-bottom: 1px solid #000000; height: 30px; text-align: left">
                <div style="font-weight: bold;font-size: 13px;letter-spacing: 0.02em;text-transform: uppercase;color: #000000; margin-bottom: 12px ;">Quantity</div>
            </th>
            <th width="40" style="border-bottom: 1px solid #000000; height: 30px; text-align: left">
                <div style="font-weight: bold;font-size: 13px;letter-spacing: 0.02em;text-transform: uppercase;color: #000000; margin-bottom: 12px ;">Unit Price</div>
            </th>
            <th width="60" style="border-bottom: 1px solid #000000; height: 30px; text-align: right;">
                <div style="font-weight: bold;font-size: 13px;letter-spacing: 0.02em;text-transform: uppercase;color: #000000; margin-bottom: 12px ; text-align: right;">Total</div>
            </th>
            <th width="30"></th>
        </tr>
        </thead>
        <tbody>
        @foreach($sales_order->sales_items as $key => $items)
            <tr>
                <td width="30"></td>
                <td style="border-bottom: 1px solid #000000; height: 30px;text-align: left;padding-left: 10px;padding-right: 10px;">
                    <div style="font-weight: 400;font-size: 12px;letter-spacing: 0.02em;color: #000000; padding-left: 10px;padding-top: 8px; margin-bottom: 8px ;margin-right: 5px;">
                        {{ $items?->variation?->variation_name }}
                    </div>
                </td>
                <td style="border-bottom: 1px solid #000000; height: 30px;text-align: left;padding-right: 10px;">
                    <div style="font-weight: 400;font-size: 12px;letter-spacing: 0.02em;color: #000000;padding-top: 8px; margin-bottom: 8px ;margin-right: 5px;">
                        {{ $items?->quantity }}
                    </div>
                </td>
                <td style="border-bottom: 1px solid #000000; height: 30px;text-align: left;padding-right: 10px;">
                    <div style="font-weight: 400;font-size: 12px;letter-spacing: 0.02em;color: #000000;padding-top: 8px; margin-bottom: 8px ;margin-right: 5px;">
                        {{ $items?->unit_sales_price }}
                    </div>
                </td>
                <td style="border-bottom: 1px solid #000000; height: 30px;text-align: right;padding-left: 10px;padding-right: 5px;">
                    <div style="font-weight: 400;font-size: 12px;letter-spacing: 0.02em;color: #000000; padding-left: 10px;padding-top: 8px; margin-bottom: 8px ;margin-right: 5px;">
                        {{ $items?->total_sales_price }}
                    </div>
                </td>
                <td width="30"></td>
            </tr>
        @endforeach
        <tr> <td height="15"></td></tr>
        <tr>
            <td width="30"></td>
            <td colspan="2"></td>
            <td style="text-align: right; font-weight: bold;">Total</td>
            <td style="text-align: right;font-weight: bold;padding-right: 5px;"> {{  $sales_order?->net_payment_amount }}</td>
            <td width="30"></td>
        </tr>
        </tbody>
    </table>
</div>
</body>
</html>
