<?php require_once '../autoloader.php';
?>

<table>
    <tr><td class="labelForm">Título</td><td><input type="text" size='50' name='titulo' required/></td>
        <td width='20'></td></tr>
    <tr><td class="labelForm">Ano</td><td><input type="text" maxlength='4' max='2100' min='0' size='4' name='ano'/></td>
        <td></td></tr>
</table>
<br/>

<?php include_once '../autor/campo.php' ?>
<br/><br/>
<?php include_once '../genero/campo.php' ?>
<br/><br/>

