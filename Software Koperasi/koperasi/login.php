<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Login</title>
</head>
<body>
<form action="?open=Login-Validasi" method="post" name="form1" target="_self" id="form1">
  <table width="450" border="0" cellpadding="2" cellspacing="1" class="table-list">
    <tr>
      <th colspan="2" bgcolor="#CCCCCC"><b>LOGIN </b>
          </td>      </th>
    </tr>
    <tr>
      <td width="117" bgcolor="#FFFFFF"><b>Username</b></td>
      <td width="263" bgcolor="#FFFFFF"><b>:
        <input name="txtUser" type="text" size="30" maxlength="20" />
      </b></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFFF"><b>Password</b></td>
      <td bgcolor="#FFFFFF"><b>:
        <input name="txtPassword" type="password" size="30" maxlength="20" />
      </b></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFFF"><b>Level  </b></td>
      <td bgcolor="#FFFFFF"><b>:
        <select name="cmbLevel">
              <option value="Kosong">....</option>
              <option value="Admin">Administrator</option>
              <option value="Kasir">Kasir</option>
        </select>
      </b></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFFF">&nbsp;</td>
      <td bgcolor="#FFFFFF"><input type="submit" name="btnLogin" value=" Login " /></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFFF">&nbsp;</td>
      <td bgcolor="#FFFFFF">&nbsp;</td>
    </tr>
  </table>
</form>
</body>
</html>
