<?php do_action('rnb_before_pickup_location'); ?>

<div id="pickupLocationPreview" class="redq-pick-up-location rnb-select-wrapper rnb-component-wrapper rq-sidebar-select"></div>

<script type="text/html" id="pickupLocationBuilder">
    <% if(items.length){ %>
    <h5><%= title %></h5>

    <?php do_action('rnb_after_pickup_location_title'); ?>

    <select class="redq-select-boxes pickup_location rnb-select-box" name="pickup_location" data-placeholder="<%= placeholder %>">
        <option value=""></option>
        <% _.each(items, function(item, index) { %>
        <option value="<%= item.id %>" <% if( selectedItem === item.slug || item.selected === 'yes' ){ %> selected <% } %>><%= item.title %></option>
        <% }) %>
    </select>
    <% } %>
</script>

<?php do_action('rnb_after_pickup_location'); ?>