<?php
$colors = [
    'red', 'black', 'green'
];

?>
<?php for ($i = 0; $i <= $count; $i++): ?>

    <div style="display:block;width:100px;height:75px;border:1px solid <?= $colors[array_rand($colors)] ?>;"> 
        <?= file_get_contents(Yii::getAlias($banner['file'])) ?>
    </div>

<?php endfor; ?>