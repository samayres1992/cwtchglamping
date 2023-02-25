<?php $colors = rnb_get_status_to_color_map(); ?>

<h3><?php esc_html_e('Color codes:', 'redq-rental') ?> </h3>
<ul class="status-colors">
    <?php foreach ($colors as $status => $color) : ?>
        <li class="status-color" style="background-color: <?php echo $color; ?>">
            <span class="status-name"><?php echo ucfirst($status); ?></span>
        </li>
    <?php endforeach; ?>
</ul>

<div class="wrap">
    <div id="redq-rental-calendar"></div>
</div>

<div id="eventContent" class="popup-modal white-popup-block mfp-hide">
    <div class="white-popup">
        <h2><a id="eventProduct" href="" target="_blank"></a></h2>
        <div id="eventInfo"></div>
        <p>
            <strong>
                <a id="eventLink" href="" target="_blank"><?php esc_html_e('View Order', 'redq-rental') ?></a>
            </strong>
        </p>
    </div>
</div>