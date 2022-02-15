<tr>
    <td align="left" valign="top" style="padding-bottom:20px;">
        <h1 style="color:#606060; font-family:'Quicksand', 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size:25px; font-style:normal; font-weight:600; line-height:35px; letter-spacing:normal; margin:0; padding:0; text-align:left;">FOVIPOL:</h1>
    </td>
</tr>
<tr>
    <td align="left" valign="top" style="padding-bottom:40px;">
        <p style="color:#606060; font-family:'Quicksand', 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size:16px; font-weight:400; line-height:24px; padding-top:0; margin-top:0; text-align:justify;">

            Estimado(a) <b>{!! $dato['full_name'] !!}  </b> {!! $dato['mensaje'] !!}

        </p>

    </td>
</tr>
@component('mail::button', ['url' => 'https://mi.fovipol.gob.pe'])
    Acceder a MI FOVIPOL
@endcomponent
