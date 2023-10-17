<!DOCTYPE html>
<html lang="en">
<head>
    <title>Barcodes</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
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
        width: 190px;
    }
    .bar-card{
        width: auto;
        height: 70px;
        padding: 10px;
        margin: 10px;
        float: left;
        border-radius: 5px;
        box-shadow: 0px 0px 1px #9a9a9a;
        border:1px solid red;
    }
    .barcode{
        width: auto;
        padding: 2px;
    }
    .amount{
        height: 20px;
        text-align: center;
        width: 100%;
        padding: 5px;
        font-weight: 500;
        font-size: 13px;
    }
    .me-2 {
        margin-right: 0.6rem !important;
    }
    .ms-2 {
        margin-left: 0.6rem !important;
    }
    hr{
        width: 100%;
        float: left;
    }
    table{
        width: 100%;
    }
</style>
    <body>
        <div class="block">
            <div class="card">
                @foreach($purchase_items as $key => $item)
                    @php
                        $loop = 1;
                        $length = $item->quantity;
                        if($item->unit == 'yard'){
                            $length = 1;
                        }
                    @endphp

                    <div style="width: 144px;padding: 2px; float: left;">
                        <table border="0">
                            <tr>
                                <td height="15" style="padding: 2px;text-align: center;">

                                </td>
                            </tr>
                            <tr>
                                <td height="5" style="text-align: center;">
                                    <span style="">{{ $item->variation_name }} </span>
                                </td>
                            </tr>
                            <tr>
                                <td height="6" style="text-align: center;font-weight: bold;"></td>
                            </tr>
                        </table>
                    </div>

                    @while($loop <= $length)
                        <div style="width: 144px;padding: 2px; float: left;">
                            <table border="0">
                                <tr>
                                    <td height="15" style="padding: 2px;text-align: center;">
                                        <img style="width: auto;" src="{{ public_path().'/generated_barcode/'.$item->id.'.png' }}">
                                    </td>
                                </tr>
                                <tr>
                                    <td height="5" style="text-align: center;">
                                        <span style=""> {{ $item->id }} </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td height="6" style="text-align: center;font-weight: bold;">{{ $item->selling_price }} Tk</td>
                                </tr>
                            </table>
                        </div>
                        @php $loop ++; @endphp
                    @endwhile
                @endforeach
            </div>
        </div>
    </body>
</html>
