<?php
include 'db_connect.php';
include 'include-admin/header.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="QR code generator and reader web app made by Murtuzaali Surti" />
    <meta name="theme-color" content="#344966" />
    <meta name="author" content="Murtuzaali Surti" />
    <link rel="manifest" href="manifest.json" />

    <title>QRCodes | QR Code Reader & Generator</title>
    <link rel="stylesheet" href="qrcode-gen/public/css/output.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Chivo:ital,wght@0,300;0,400;0,700;1,400&family=Fira+Code:wght@300;400;600;700&family=Inter:wght@300;400;500;700&family=Josefin+Sans:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,700&family=Lato:ital,wght@0,300;0,400;0,700;1,400;1,700&family=Libre+Baskerville&family=Merriweather&family=Noto+Sans:ital,wght@0,400;0,700;1,400;1,700&family=Nunito:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,700&family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500&family=Quicksand&family=Ubuntu:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

    <style>
        .card {
            background-color: transparent;
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 10px;
        }

        .row {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            gap: 20px;
        }

        .qr-code-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 20px;
        }

        .qr-code {
            /* Add your styles for the QR code container */
        }

        .download-button {
            margin-top: 20px;
        }

        .small-input {
            width: 500px;
            /* Adjust the width as per your preference */
            padding: 5px;
            /* Adjust the padding as needed */
        }

        .user-input {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .button-container {
            display: flex;
            justify-content: center;
        }

        .p-3.flex-fill {
            display: grid;
            justify-content: center;
            align-items: center;
            height: 100%;
        }

        .qr-code-container {
            width: 1000px;
            /* Adjust the width as needed */
            height: 400px;
            /* Adjust the height as needed */
            /* background-color: #f1f1f1; */
            /* Optional background color for visualization */
        }
    </style>

</head>

<?php
if ($_SESSION['login_type'] == 1) :
?>

<div class="mdl-cell mdl-cell--12-col-desktop mdl-cell--12-col-tablet mdl-cell--12-col-phone" style="display: flex; justify-content: center; align-items: center;">
    <span style="color: white; font-size: 24px;">Generate QR Code</span>
</div>
<center>
    <div class="card">
        <div class="card-body">
            <div class="d-flex">
                <div class="p-2 flex-fill">
                    <section class="user-input">
                        <input type="text" placeholder="" class="form-control small-input" name="form-control" id="input_text" autocomplete="off" />
                        <hr>
                        <div class="button-container">
                            <button class="button" type="submit">
                                Generate<i class="fa-solid fa-rotate"></i>
                            </button>
                        </div>
                        <div class="error" style="display: none"></div>
                    </section>
                </div>
                <div class="p-2 flex-fill">
                    <div class="qr-code-container">
                        <div class="qr-code"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</center>

</html>

<script src="qrcode-gen/public/js/minified/prod.min.js"></script>

<?php
    include 'include-admin/script.php';
?>

<?php
endif;
?>