<tr>
    <td align="left" valign="top" style="padding-bottom:20px;">
        <h1 style="color:#606060; font-family:'Quicksand', 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size:25px; font-style:normal; font-weight:600; line-height:35px; letter-spacing:normal; margin:0; padding:0; text-align:left;">
            ¿Olvidó su contraseña? Le ayudaremos a recuperarla.</h1>
    </td>
</tr>
<tr>
    <td align="left" valign="top" style="padding-bottom:40px;">
        <p style="color:#606060; font-family:'Quicksand', 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size:16px; font-weight:400; line-height:24px; padding-top:0; margin-top:0; text-align:left;">
            Estimado <b>{{ $fullName }}</b> hemos recibido una solicitud de recuperación de
            contraseña. Si usted no solicitó la recuperación de contraseña ignore este
            correo.
        </p>
        <p style="color:#606060; font-family:'Quicksand', 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size:16px; font-weight:400; line-height:24px; padding-top:0; margin-top:0; text-align:left;">
            <b>
                Código de verificación: {{ $token  }}
            </b>
        </p>
    </td>
</tr>
@component('mail::button', ['url' => 'https://mi.fovipol.gob.pe'])
    Acceder al APP FOVIPOL
@endcomponent
