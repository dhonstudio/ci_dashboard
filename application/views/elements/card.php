<style>
    .card_identity {
        position: absolute;
        top: 60%;
        left: 12%;
    }

    .card_qrcode {
        position: absolute;
        top: 30%;
        right: 12%;
    }
</style>
<div class="col-xl-4">
    <div class="card mb-4 border-0">
        <img src="https://dhonstudio.com/ci/dashboard/assets/img/blank_card.png">
        <div class="card_identity">
            <b class="h5"><?= $number?></b><br>
            <b class="h5"><?= $name ?></b>
        </div>
        <div class="card_qrcode">
            <img src="<?= $qrcode ?>">
        </div>
    </div>
</div>