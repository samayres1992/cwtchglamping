<?php
$arrContextOptions = [
    "ssl" => [
        "verify_peer"      => false,
        "verify_peer_name" => false,
    ],
];

$file        = file_get_contents("https://s3.amazonaws.com/redqteam.com/rnb/addons/addons.json", false, stream_context_create($arrContextOptions));
$addons_json = json_decode($file, true);
$add_ons     = $addons_json['data'];
?>

<div class="wrap woocommerce wc_addons_wrap rnb_addons_wrap">
    <div class="addons-banner-block">

        <?php if (empty($add_ons)) : ?>
            <h4><?php echo esc_html__('Sorry! No Data Found', 'redq-rental'); ?></h4>
        <?php endif; ?>

        <div class="addons-banner-block-items">
            <?php foreach ($add_ons as $key => $add_on) : ?>
                <div class="storefront rnb-addon rnb-addon-<?php echo esc_attr($key + 1); ?>">
                    <div class="rnb-addon-thumb-wrapper">
                        <img src="<?php echo esc_url($add_on['image_url']); ?>" alt="RnB Seasonal Pricing">
                        <a href="<?php echo esc_url($add_on['url']); ?>" target="_blank"></a>
                        <div class="thumb-overlay">
                            <a href="<?php echo esc_url($add_on['demo_url']); ?>" target="_blank" class="button button-primary">
                                <span class="icon"><svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M21.5776 23.1686C17.6022 26.3526 11.783 26.102 8.09787 22.4168C4.14381 18.4628 4.14381 12.052 8.09787 8.0979C12.0519 4.14384 18.4627 4.14384 22.4168 8.0979C26.102 11.7831 26.3526 17.6022 23.1686 21.5776L30.902 29.3111C31.3414 29.7504 31.3414 30.4627 30.902 30.9021C30.4627 31.3414 29.7504 31.3414 29.311 30.9021L21.5776 23.1686ZM9.68886 20.8258C6.61348 17.7504 6.61348 12.7643 9.68886 9.68889C12.7642 6.61351 17.7504 6.61351 20.8258 9.68889C23.8989 12.762 23.9012 17.7431 20.8326 20.819C20.8303 20.8213 20.828 20.8235 20.8258 20.8258C20.8235 20.828 20.8213 20.8303 20.819 20.8326C17.7431 23.9012 12.762 23.8989 9.68886 20.8258Z" fill="currentcolor" />
                                    </svg></span>
                                <?php echo esc_html__('Preview', 'redq-rental'); ?>
                            </a>
                            <a href="<?php echo esc_url($add_on['url']); ?>" target="_blank" class="button">
                                <span class="icon"><svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M28.7216 7.875H8.00271L6.23245 4.70189C6.03375 4.34573 5.65784 4.125 5.25 4.125H3C2.37868 4.125 1.875 4.62868 1.875 5.25C1.875 5.87132 2.37868 6.375 3 6.375H4.5894L6.33644 9.50648L10.3656 18.4213L10.3697 18.4304L10.7246 19.2156L6.6793 23.5306C6.38843 23.8408 6.29738 24.2886 6.44398 24.6878C6.59057 25.087 6.94976 25.3694 7.37229 25.4177L11.0595 25.8391C15.6715 26.3662 20.3286 26.3662 24.9406 25.8391L28.6278 25.4177C29.2451 25.3472 29.6883 24.7896 29.6178 24.1723C29.5472 23.555 28.9896 23.1117 28.3723 23.1823L24.6851 23.6037C20.2428 24.1114 15.7572 24.1114 11.315 23.6037L9.85169 23.4364L12.8208 20.2694C12.8495 20.2388 12.8762 20.207 12.9008 20.1742L14.03 20.3211C15.6124 20.527 17.2119 20.5674 18.8027 20.4415C22.5129 20.1481 25.9515 18.3826 28.3522 15.5386L29.2193 14.5114C29.2484 14.4769 29.2754 14.4407 29.3002 14.4029L30.9163 11.9401C32.0618 10.1945 30.8095 7.875 28.7216 7.875ZM12.9844 17.9161C12.7363 17.8838 12.5223 17.7262 12.4179 17.4991L12.4159 17.4947L9.08511 10.125H28.7216C29.0199 10.125 29.1988 10.4564 29.0351 10.7057L27.4562 13.1118L26.6329 14.0873C24.6198 16.4721 21.7364 17.9525 18.6253 18.1985C17.1904 18.312 15.7476 18.2756 14.3203 18.0899L12.9844 17.9161Z" fill="currentcolor" />
                                        <path d="M9.75 27.75C8.50736 27.75 7.5 28.7574 7.5 30C7.5 31.2426 8.50736 32.25 9.75 32.25C10.9926 32.25 12 31.2426 12 30C12 28.7574 10.9926 27.75 9.75 27.75Z" fill="currentcolor" />
                                        <path d="M24 30C24 28.7574 25.0074 27.75 26.25 27.75C27.4926 27.75 28.5 28.7574 28.5 30C28.5 31.2426 27.4926 32.25 26.25 32.25C25.0074 32.25 24 31.2426 24 30Z" fill="currentcolor" />
                                    </svg></span>
                                <?php echo esc_html__('Buy Now', 'redq-rental'); ?>
                            </a>
                        </div>
                    </div>
                    <div class="rnb-addon-info">
                        <img src="<?php echo RNB_ASSETS . $add_on['marketplace_image'] ?>" alt="Market Place">
                        <div class="meta-info">
                            <h2><a href="<?php echo esc_url($add_on['demo_url']); ?>" target="_blank"><?php echo wp_kses($add_on['title'], wp_kses_allowed_html()); ?></a></h2>
                            <p><?php echo wp_kses($add_on['subtitle'], wp_kses_allowed_html()); ?></p>
                        </div>
                        <div class="price"><?php echo $add_on['price']; ?></div>
                    </div>
                    <?php if (isset($add_on['excerpt'])) : ?>
                        <p><?php echo wp_kses($add_on['excerpt'], wp_kses_allowed_html()); ?></p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>