<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>文件域</title>
</head>
<body>
<table width="100%" cellspacing="0" cellpadding="0">
  <tr>
    <td><form action=<?="http://" . $_SERVER ['HTTP_HOST'] . ":8080/activiti-rest/service/repository/deployments"?> name="form1" method="post" enctype="multipart/form-data"target="_blank" >

      <p>部署id:
        <input name="tenantId" type="input"  size="30" maxlength="40" />
        <input name="fileField" type="file" id="fileField" size="10" maxlength="40" />
      </p>
	  <p>
        <input name="submit" type="submit" value="提交" />
        <input name="reset" type="reset" value="重置" />
      </p>
</form></td>
  </tr>
</table>
</body>
</html>