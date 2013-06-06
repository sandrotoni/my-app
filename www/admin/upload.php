<?php

if (isset($_POST['liteUploader_id']) && $_POST['liteUploader_id'] == 'fileUpload1')
{
foreach ($_FILES['fileUpload1']['error'] as $key => $error)
{
if ($error == UPLOAD_ERR_OK)
{
move_uploaded_file( $_FILES['fileUpload1']['tmp_name'][$key], '../img/' . $_FILES['fileUpload1']['name'][$key]);
}
}

echo '<b>***** Upload effettuato correttamente !!! *****</b>';
}

if (isset($_POST['liteUploader_id']) && $_POST['liteUploader_id'] == 'fileUpload2')
{
foreach ($_FILES['fileUpload2']['error'] as $key => $error)
{
if ($error == UPLOAD_ERR_OK)
{
move_uploaded_file( $_FILES['fileUpload2']['tmp_name'][$key], '../images/' . $_FILES['fileUpload2']['name'][$key]);
}
}

echo '<b>***** Upload effettuato correttamente !!! *****</b>';
}

?>