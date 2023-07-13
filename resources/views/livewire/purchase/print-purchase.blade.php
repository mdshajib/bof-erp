<!DOCTYPE html>
<html lang="en">
    <head>
    <title>Purchase Print</title>
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
                <tr><td height="5"></td></tr>
                <tr><td style="text-align: center;"><h3 style="font-size: 14px;">Purchase Order: {{ $purchase_order?->purchase_number }}</h3></td></tr>
                <tr><td height="5"></td></tr>
                <tr><td style="text-align: center;"><h3 style="font-size: 14px;">Purchase Date: {{ $purchase_order?->order_date }}</h3></td></tr>
                <tr><td height="15"></td></tr>
            </table>

            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <thead>
                    <tr>
                        <th width="20"></th>
                        <th width="200" style="border-bottom: 1px solid #000000; height: 30px;text-align: left;">
                            <div style="font-weight: bold;font-size: 13px;letter-spacing: 0.02em;text-transform: uppercase;color: #000000; margin-bottom: 12px ; margin-left: 10px;">Product</div>
                        </th>
                        <th width="150" style="border-bottom: 1px solid #000000; height: 30px; text-align: left">
                            <div style="font-weight: bold;font-size: 13px;letter-spacing: 0.02em;text-transform: uppercase;color: #000000; margin-bottom: 12px ;">Supplier</div>
                        </th>
                        <th width="60" style="border-bottom: 1px solid #000000; height: 30px; text-align: right;">
                            <div style="font-weight: bold;font-size: 13px;letter-spacing: 0.02em;text-transform: uppercase;color: #000000; margin-bottom: 12px ; text-align: right;">Quantity</div>
                        </th>
                        <th width="20"></th>
                    </tr>
                </thead>
                <tbody>
                @foreach($purchase_order->purchase_items as $key => $purchase_item)
                    <tr>
                        <th width="20"></th>
                        <td style="border-bottom: 1px solid #000000; height: 30px;text-align: left;padding-left: 10px;padding-right: 10px;">
                            <div style="font-weight: 400;font-size: 12px;letter-spacing: 0.02em;color: #000000; padding-left: 10px;padding-top: 8px; margin-bottom: 8px ;margin-right: 5px;">
                                {{ $purchase_item?->variation?->variation_name }}
                            </div>
                        </td>
                        <td style="border-bottom: 1px solid #000000; height: 30px;text-align: left;padding-left: 10px;padding-right: 10px;">
                            <div style="font-weight: 400;font-size: 12px;letter-spacing: 0.02em;color: #000000; padding-left: 10px;padding-top: 8px; margin-bottom: 8px ;margin-right: 5px;">
                                {{ $purchase_item?->product?->supplier?->name }}
                            </div>
                        </td>
                        <td style="border-bottom: 1px solid #000000; height: 30px;text-align: right;padding-left: 10px;padding-right: 10px;">
                            <div style="font-weight: 400;font-size: 12px;letter-spacing: 0.02em;color: #000000; padding-left: 10px;padding-top: 8px; margin-bottom: 8px ;margin-right: 5px;">
                                {{ $purchase_item->quantity }}
                            </div>
                        </td>
                        <th width="20"></th>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </body>
</html>
