<?php do_action('rnb_before_return_location'); ?>

<div id="dropoffLocationPreview" class="redq-pick-up-location rnb-select-wrapper rnb-component-wrapper rq-sidebar-select"></div>

<script type="text/html" id="dropoffLocationBuilder">
    <% if(items.length){ %>

    <h5><%= title %></h5>

    <?php do_action('rnb_after_return_location_title'); ?>

    <select class="redq-select-boxes dropoff_location rnb-select-box" name="dropoff_location" data-placeholder="<%= placeholder %>">
        <option value=""></option>
        <% _.each(items, function(item, index) { %>
        <option value="<%= item.id %>" <% if( ( selectedItem === item.slug) || item.selected === 'yes' ){ %> selected <% } %>><%= item.title %></option>
        <% }) %>
    </select>
    <% } %>
</script>

<?php do_action('rnb_after_return_location'); ?>