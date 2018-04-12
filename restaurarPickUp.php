<?php
    session_start();
?>
<form action="restauracion.php" method="get" enctype="multipart/form-data" name="formularioDeRestauracion" id="formularioDeRestauracion" onsubmit="return enviar();">
    <table width="334" border="0" align="center">
        <tr>
            <td colspan="2"><h4>Indique el or&iacute;gen del archivo de copia</h4></td>
        </tr>
        <tr>
            <td width="151">&nbsp;</td>
            <td width="167">&nbsp;</td>
        </tr>
        <tr>
            <td><input type="file" name='ficheroDeCopia' id='ficheroDeCopia'/></td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td width="151" height="36"><input type="submit" name="envio" id="envio" value="[ Aceptar ]" /> </td>
            <tr>
                <td align="center" width="151" height="85"><div id="cargando"></div></td>
                <td width="167">&nbsp;</td>
            </tr>
        </tr>
    </table>
</form>