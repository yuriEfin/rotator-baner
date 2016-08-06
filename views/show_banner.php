<?php
$colors = [
    'red', 'black', 'green'
];

?>
<?php for ($i = 0; $i <= $count; $i++): ?>

    <div style="display:block;width:100px;height:75px;border:1px solid <?= $colors[array_rand($colors)] ?>;"> 
        <?=
        strtr(file_get_contents(Yii::getAlias($banner['file'])), [
            '{id}' => isset($banner['id']) ? $banner['id'] : uniqid(),
            '{url}' => isset($banner['url']) ? $banner['url'] : '',
        ])

        ?>
    </div>

<?php endfor; ?>