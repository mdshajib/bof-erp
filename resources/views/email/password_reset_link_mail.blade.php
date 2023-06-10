@include('email.inc.header')
<table width="100%" cellpadding="0" cellspacing="0" border="0" style="background: #ffffff;">
    <tr>
        <td width="56"></td>
        <td>
            <div style="font-weight: 400;font-size: 14px;line-height: 24px; color: #000000;">
                <div>
                    Greetings,
                </div>
                <div style="height: 30px;"></div>
                <div>
                    <p>
                        Please change your password from the following link :
                    </p>
                    <a href="{{ route('password.reset', $token) }}" class="">Reset Password</a>
                </div>

                <div style="height: 35px;"></div>
                <div style="font-weight: 400;font-size: 14px;line-height: 24px;">Thank you, <br>{{ config('app.name') }}.</div>
                <div style="height: 92px;"></div>
            </div>
        </td>
        <td width="56"></td>
    </tr>
</table>
@include('email.inc.footer')
