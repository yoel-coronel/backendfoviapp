<tr>
    <td align="left" valign="top"
        style="padding-bottom:20px;">
        <h1 style="color:#606060; font-family:'Quicksand', 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size:30px; font-style:normal; font-weight:600; line-height:42px; letter-spacing:normal; margin:0; padding:0; text-align:left;">
            Has recibido un mensaje desde un tramite.
        </h1>
    </td>
</tr>
<tr>
    <td align="left" valign="top"
        style="padding-bottom:40px;">
        <p style="color:#606060; font-family:'Quicksand', 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size:16px; font-weight:400; line-height:24px; padding-top:0; margin-top:0; text-align:left;">
            El mensaje fue enviado por {{ $sender_name }} (CIP #{{ $sender_cip }}) desde el
            trámite "{{ $procedure_name }}" (#{{ $procedure_id }})
            en el área "{{ $area_name }}" desde el proceso pendiente
            "{{ $process_name }}"
        </p>
        <p style="color:#606060; font-family:'Quicksand', 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size:16px; font-weight:400; line-height:24px; padding-top:0; margin-top:0; text-align:left;">
            El mensaje es el siguiente <br>
            {{ $message }}
        </p>
    </td>
</tr>
