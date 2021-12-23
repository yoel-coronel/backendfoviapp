<tr>
    <td align="left" valign="top"
        style="padding-bottom:20px;">
        <h1 style="color:#606060; font-family:'Quicksand', 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size:30px; font-style:normal; font-weight:600; line-height:42px; letter-spacing:normal; margin:0; padding:0; text-align:left;">
            MI FOVIPOL, documentos adjuntos del tramite N°  {{ $idtramite }}
        </h1>
    </td>
</tr>
<tr>
    <td align="left" valign="top"
        style="padding-bottom:40px;">
        <p style="color:#606060; font-family:'Quicksand', 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size:16px; font-weight:400; line-height:24px; padding-top:0; margin-top:0; text-align:left;">
            Estimado, se ha enviado a su bandeja de trabajo los documentos adjuntos del Sr(a). {{$name}} con N° de tramite {{ $idtramite }} , desde la plataforma MIFOVIPOL, quedando pendiente de su parte la verificación de los documentos. </p>
        <p style="color:#606060; font-family:'Quicksand', 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size:16px; font-weight:400; line-height:24px; padding-top:0; margin-top:0; text-align:left;">
            Saludos, MIFOVIPOL.
        </p>
        <!-- <p style="color:#606060; font-family:'Quicksand', 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size:16px; font-weight:400; line-height:24px; padding-top:0; margin-top:0; text-align:left;">
            <b>
               DIRIGIDO:{{$email}}
            </b>
        </p> -->

    </td>
</tr>
{{-- @component('mail::button', ['url' => route('home')])

    Acceder a MIFovipol
@endcomponent --}}