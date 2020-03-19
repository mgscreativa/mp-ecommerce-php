jQuery(document).ready(() => {
    let cartProducts = [];
    let cartTotal = 0;

    const processCheckoutButton = jQuery('#process-checkout');

    processCheckoutButton.prop("disabled", true);

    jQuery('.as-producttile-info button').on('click', e => {
        e.preventDefault();
        e.stopPropagation();

        const productId = cartProducts.length;
        const productName = jQuery(e.target).closest(".as-producttile-info").find(".as-producttile-tilelink span").text().trim();
        const productPrice = Number(jQuery(e.target).closest(".as-producttile-info").find(".as-price-currentprice.as-producttile-currentprice").text().trim().replace(/\D/g, '')); // .replace(/[^\d.-]/g, ''));
        const productImage = jQuery(e.target).closest(".as-producttile").find(".ir.ir.item-image.as-producttile-image").attr('src');

        cartTotal += productPrice;
        jQuery(".cart-total").text(`Total: ${cartTotal}`);

        cartProducts.push({productId, productName, productPrice, productImage});

        processCheckoutButton.prop("disabled", false);

        jQuery(".as-accordion-item.products > div").append(`<div class="as-accordion-header as-search-accordion-header"><span class="as-accordion-title as-search-accordion-title product-name"><span id="${productId}" class="removeProduct"></span>${productName}</span><span class="as-accordion-title price">${productPrice}</span></div>`);

        renderProductsInputs(cartProducts);

        jQuery('.removeProduct').on('click', e => {
            e.preventDefault();
            e.stopPropagation();

            const productElement = jQuery(e.target);
            const productIdToRemove = Number(productElement.attr('id'));

            productElement.closest(".as-accordion-header.as-search-accordion-header").remove();

            const indexToRemove = cartProducts.findIndex(product => {
                return product.productId === productIdToRemove;
            });

            indexToRemove >= 0 ? cartProducts.splice(indexToRemove, 1) : '';

            cartProducts.length === 0 ? cartTotal = 0 : jQuery.map(cartProducts, (product, i) => {
                i === 0 ? cartTotal = 0 : '';

                cartTotal += product.productPrice;
            });

            const cartTotalElement = jQuery(".cart-total");

            if (cartProducts.length === 0) {
                processCheckoutButton.prop("disabled", true);
                cartTotalElement.text('')
            } else {
                cartTotalElement.text(`Total: ${cartTotal}`);
            }

            renderProductsInputs(cartProducts);
        });
    });

    const renderProductsInputs = products => {
        jQuery('input[name="products[]"]').remove()

        jQuery.map(products, (product, i) => {
            jQuery('#process-payment').append(`<input type="hidden" name="products[]" value='${JSON.stringify(product)}' />`);
        });
    };
});
