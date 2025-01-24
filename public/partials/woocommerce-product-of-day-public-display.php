<?php
/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://wooninjas.com/
 * @since      1.0.0
 *
 * @package    Woocommerce_Product_Of_Day
 * @subpackage Woocommerce_Product_Of_Day/public/partials
 */
?>

<!-- FLOATING BUTTON BEGIN -->
<button id="check-for-pod"> 
    <img src="https://img.icons8.com/pastel-glyph/64/FFFFFF/shopping-cart--v2.png" alt="Product of the Day" />
</button>
<!-- FLOATING BUTTON END -->

<!-- Product of the Day Box Begin -->
<div class="woo-day-product" id="today-product">
    <div class="woo-day-product-header">
        <button id="close-panel-pod"> &#215; </button>
        <h3><?php echo html_entity_decode($wn_product_of_day_title); ?></h3>
    </div>
    <div class="woo-day-product-body-wrapper">
        <?php foreach ($wn_product_of_day_selected_products as $index => $product_id): ?>
            <?php
            $product_id = intval($product_id);
            $productx = wc_get_product($product_id);
            if (is_object($productx)):
            ?>
                <div class="woo-day-product-item" data-index="<?php echo $index; ?>" style="display: <?php echo $index === 0 ? 'block' : 'none'; ?>;">
                    <div class="woo-day-product-body">
                        <?php echo $productx->get_image(); ?>
                    </div>
                    <div class="woo-product-day-detail">
                        <h2><?php echo $productx->get_name(); ?></h2>
                    </div>
                    <div class="woo-day-product-footer">
                        <?php echo do_shortcode('[add_to_cart id="' . $product_id . '" style="" show_price="true" quantity="1"]'); ?>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>

    <!-- Navigation Buttons -->
    <div class="woo-day-product-navigation">
        <button id="prev-product" disabled>Previous</button>
        <button id="next-product">Next</button>
    </div>
</div>
<!-- Product of the Day Box End -->



<script>
jQuery(document).ready(function () {
    const $checkForPod = jQuery("#check-for-pod");
    const $todayProduct = jQuery("#today-product");
    const $prevProduct = jQuery("#prev-product");
    const $nextProduct = jQuery("#next-product");
    const $products = jQuery(".woo-day-product-item");
    const totalProducts = $products.length;
    let currentIndex = 0;

    // Initially hide the product container and show the floating button
    $todayProduct.hide();
    $checkForPod.show();

    // Show product container on cart icon click
    $checkForPod.click(function () {
        $checkForPod.fadeOut();
        $todayProduct.fadeIn();
    });

    // Hide product container on close button click
    jQuery("#close-panel-pod").click(function () {
        $todayProduct.fadeOut();
        $checkForPod.fadeIn(1500);
    });

    // Show next product
    $nextProduct.click(function () {
        if (currentIndex < totalProducts - 1) {
            $products.eq(currentIndex).fadeOut(500, function () {
                currentIndex++;
                $products.eq(currentIndex).fadeIn(500);
                toggleNavButtons();
            });
        }
    });

    // Show previous product
    $prevProduct.click(function () {
        if (currentIndex > 0) {
            $products.eq(currentIndex).fadeOut(500, function () {
                currentIndex--;
                $products.eq(currentIndex).fadeIn(500);
                toggleNavButtons();
            });
        }
    });

    // Enable/Disable navigation buttons
    function toggleNavButtons() {
        $prevProduct.prop("disabled", currentIndex === 0);
        $nextProduct.prop("disabled", currentIndex === totalProducts - 1);
    }
});


</script>
<style>

/* Navigation buttons styling */
.woo-day-product-navigation {
    display: flex;
    justify-content: space-between;
    padding: 10px;
    background-color: #f4f4f4;
}

.woo-day-product-navigation button {
    background-color: #2c3e50;
    color: white;
    border: none;
    padding: 8px 16px;
    font-size: 14px;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.woo-day-product-navigation button:disabled {
    background-color: #bdc3c7;
    cursor: not-allowed;
}

.woo-day-product-navigation button:hover:not(:disabled) {
    background-color: #34495e;
}

/* Floating Button for Product of the Day */


#check-for-pod:hover {
    transform: scale(1.1);
}

#check-for-pod img {
    width: 30px;
    height: 30px;
}

/* Optional: Adding a little fade-in effect for the product box */
@keyframes fadeIn {
    0% {
        opacity: 0;
    }
    100% {
        opacity: 1;
    }
}


</style>