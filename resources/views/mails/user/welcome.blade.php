<tr>
    <td align="left" valign="top"
        style="padding-bottom:20px;">
        <h1 style="color:#606060; font-family:'Quicksand', 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size:30px; font-style:normal; font-weight:600; line-height:42px; letter-spacing:normal; margin:0; padding:0; text-align:left;">
            Bienvenido al APP FOVIPOL
        </h1>
    </td>
</tr>
<tr>
    <td align="left" valign="top"
        style="padding-bottom:40px;">
        <p style="color:#606060; font-family:'Quicksand', 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size:16px; font-weight:400; line-height:24px; padding-top:0; margin-top:0; text-align:left;">
            Desde MiFovipol podrás acceder a tu estado de cuenta, seguimiento de trámites,
            historial de aportes y simulación de prestamos. </p>
        <p style="color:#606060; font-family:'Quicksand', 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size:16px; font-weight:400; line-height:24px; padding-top:0; margin-top:0; text-align:left;">
            Recuerda que para ingresar a su cuenta debes ingresar los siguientes datos:
        </p>
        <p style="color:#606060; font-family:'Quicksand', 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size:16px; font-weight:400; line-height:24px; padding-top:0; margin-top:0; text-align:left;">
            <b>
                Número CIP: {{ $user['cip'] }} <br>
                Contraseña: {{ $clave  }}
            </b>
        </p>

    </td>
</tr>
@component('mail::button', ['url' => 'https://mi.fovipol.gob.pe'])

    Acceder al APP FOVIPOL

@endcomponent
