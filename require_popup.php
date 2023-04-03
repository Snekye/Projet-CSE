<?php
if (isset($message)) { ?>
<div class="popup" onclick="vanish()">
    <p class="popuptext"><?=$message?></p>
</div>

<?php } ?>

<style>
    .popup {
    position: fixed;
    width: 80%;
    margin: 0 10% 0 10%;
    border: 3px solid #000000;
    z-index: 1;
    text-align: center;
    background-color: #FFFFFF;
    transition: .5s;
    border-radius: 5px;
    top: 80%;
}
.popuptext {
    padding: 1%;
}
.popup:hover {
    transform: scale(1.02);
}
</style>

<script>
    function vanish() {
    document.getElementsByClassName("popup")[0].setAttribute("style","display: none;")
}
</script>