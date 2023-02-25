<?php
// Add plugin-specific colors and fonts to the custom CSS
if ( !function_exists( 'the_mounty_tribe_events_get_css' ) ) {
	add_filter( 'the_mounty_filter_get_css', 'the_mounty_tribe_events_get_css', 10, 2 );
	function the_mounty_tribe_events_get_css($css, $args) {
		if (isset($css['fonts']) && isset($args['fonts'])) {
			$fonts = $args['fonts'];
			$css['fonts'] .= <<<CSS
			

.tribe-events-list .tribe-events-list-event-title,
.tribe-common--breakpoint-medium.tribe-common .tribe-common-h6--min-medium,
.tribe-common .tribe-common-h1, .tribe-common .tribe-common-h2,
.tribe-common .tribe-common-h3, .tribe-common .tribe-common-h4,
.tribe-common .tribe-common-h5, .tribe-common .tribe-common-h6,
.tribe-common .tribe-common-h7, .tribe-common .tribe-common-h8,
.tribe-events-calendar-month__header-column-title.tribe-common-b3,
.tribe-common .tribe-common-anchor-alt {
	{$fonts['h3_font-family']}
}


#tribe-events .tribe-events-button,
.tribe-events-button,
.tribe-events-cal-links a,
.tribe-events-sub-nav li a {
	{$fonts['button_font-family']}
	{$fonts['button_font-size']}
	{$fonts['button_font-weight']}
	{$fonts['button_font-style']}
	{$fonts['button_line-height']}
	{$fonts['button_text-decoration']}
	{$fonts['button_text-transform']}
	{$fonts['button_letter-spacing']}
}

#tribe-bar-form button, #tribe-bar-form a,
.tribe-events-read-more,
.tribe-events-list .tribe-events-list-separator-month,
.tribe-events-c-view-selector__list-item-link,
.tribe-events-calendar thead th,
.tribe-events-schedule, .tribe-events-schedule h2,
.tribe-events .tribe-events-c-view-selector__list-item-text,
.tribe-common .tribe-common-h3 .tribe-events-c-top-bar__datepicker-desktop,
.tribe-common-h3.tribe-common-h--alt.tribe-events-c-top-bar__datepicker-button,
.tribe-common .tribe-common-c-btn.tribe-events-c-search__button,
.tribe-common .tribe-common-c-btn-border, .tribe-common a.tribe-common-c-btn-border,
.tribe-common--breakpoint-medium.tribe-events .tribe-events-c-nav__next, 
.tribe-common--breakpoint-medium.tribe-events .tribe-events-c-nav__prev,
.tribe-events-c-nav__list-item.tribe-events-c-nav__list-item--prev .tribe-events-c-nav__prev,
.tribe-events-c-nav__list-item.tribe-events-c-nav__list-item--next .tribe-events-c-nav__next,
.tribe-common .tribe-common-anchor-alt, .tribe-events .tribe-events-c-ical__link {
	{$fonts['button_font-family']}
	{$fonts['button_font-weight']}
	{$fonts['button_letter-spacing']}
}
.tribe-common .tribe-common-c-btn-border-small,
.tribe-common a.tribe-common-c-btn-border-small,
.tribe-events-calendar td div[id*="tribe-events-daynum-"], 
.tribe-events-calendar td div[id*="tribe-events-daynum-"] a,
.tribe-events-list .tribe-events-list-separator-month,
.tribe-events-calendar thead th,
.tribe-events .datepicker .datepicker-switch,
.tribe-events-schedule, .tribe-events-schedule h2,
.tribe-events-calendar-day__event-title.tribe-common-h6.tribe-common-h4--min-medium,
.tribe-events-calendar-list__event-title.tribe-common-h6.tribe-common-h4--min-medium,
.tribe-events-calendar-day__event-title.tribe-common-h6.tribe-common-h4--min-medium a,
.tribe-events-calendar-list__event-title.tribe-common-h6.tribe-common-h4--min-medium a  {
	{$fonts['h5_font-family']}
}

.tribe-events-event-meta,
.tribe-events-content,
#tribe-bar-form input, #tribe-events-content.tribe-events-month,
#tribe-events-content .tribe-events-calendar div[id*="tribe-events-event-"] h3.tribe-events-month-event-title,
#tribe-mobile-container .type-tribe_events,
.tribe-events-list-widget ol li .tribe-event-title,
.tribe-events .datepicker .day,
.tribe-common .tribe-common-b1,
.tribe-common .tribe-common-b2,
.tribe-common .tribe-common-c-btn, .tribe-common a.tribe-common-c-btn,
.tribe-events .tribe-events-calendar-list__event-date-tag-weekday,
.tribe-events .tribe-events-calendar-month__calendar-event-datetime,
.tribe-common--breakpoint-medium.tribe-common .tribe-common-form-control-text__input, 
.tribe-common .tribe-common-form-control-text__input,
.tribe-common .tribe-events-calendar-month__calendar-event-tooltip-description.tribe-common-b3,
.tribe-events .tribe-events-calendar-month__calendar-event-tooltip-datetime  {
	{$fonts['p_font-family']}
}

.tribe-events-loop .tribe-event-schedule-details,
.single-tribe_events #tribe-events-content .tribe-events-event-meta dt,
#tribe-mobile-container .type-tribe_events .tribe-event-date-start {
	{$fonts['info_font-family']};
}

CSS;
		}


		if (isset($css['colors']) && isset($args['colors'])) {
			$colors = $args['colors'];
			$css['colors'] .= <<<CSS

/* Filters bar */
#tribe-bar-form {
	color: {$colors['text_dark']};
}
#tribe-bar-form input[type="text"] {
	color: {$colors['text_dark']};
	border-color: {$colors['text_dark']};
}
.tribe-bar-views-list {
	background-color: {$colors['text_link']};
}

.datepicker thead tr:first-child th:hover, .datepicker tfoot tr th:hover {
	color: {$colors['text_link']};
	background: {$colors['text_dark']};
}

/* Content */
.tribe-events-calendar thead th {
	color: {$colors['bg_color']};
	background: {$colors['text_link']} !important;
	border-color: {$colors['text_link']} !important;
}
.tribe-events-calendar thead th + th:before {
	background: {$colors['bg_color']};
}
#tribe-events-content .tribe-events-calendar td {
	border-color: {$colors['bd_color']} !important;
}
.tribe-events-calendar td div[id*="tribe-events-daynum-"],
.tribe-events-calendar td div[id*="tribe-events-daynum-"] > a {
	color: {$colors['text_dark']};
}
.tribe-events-calendar td.tribe-events-othermonth {
	color: {$colors['alter_light']};
	background: {$colors['alter_bg_color']} !important;
}
.tribe-events-calendar td,
.tribe-events-calendar td.tribe-events-othermonth {
	background: {$colors['bg_color']} !important;
}
.tribe-events-calendar td.tribe-events-othermonth div[id*="tribe-events-daynum-"],
.tribe-events-calendar td.tribe-events-othermonth div[id*="tribe-events-daynum-"] > a {
	color: {$colors['alter_light']};
}
.tribe-events-calendar td.tribe-events-past div[id*="tribe-events-daynum-"], .tribe-events-calendar td.tribe-events-past div[id*="tribe-events-daynum-"] > a {
	color: {$colors['text_light']};
}
.tribe-events-calendar td.tribe-events-present div[id*="tribe-events-daynum-"],
.tribe-events-calendar td.tribe-events-present div[id*="tribe-events-daynum-"] > a {
	color: {$colors['text_link']};
}
.tribe-events-calendar td.tribe-events-present:before {
	border-color: {$colors['text_link']};
}
.tribe-events-calendar .tribe-events-has-events:after {
	background-color: {$colors['text']};
}
.tribe-events-calendar .mobile-active.tribe-events-has-events:after {
	background-color: {$colors['text_link']};
}
#tribe-events-content .tribe-events-calendar td,
#tribe-events-content .tribe-events-calendar div[id*="tribe-events-event-"] h3.tribe-events-month-event-title a {
	color: {$colors['text_dark']};
}
#tribe-events-content .tribe-events-calendar div[id*="tribe-events-event-"] h3.tribe-events-month-event-title a:hover {
	color: {$colors['text_link']};
}
#tribe-events-content .tribe-events-calendar td.mobile-active,
#tribe-events-content .tribe-events-calendar td.mobile-active:hover {
	color: {$colors['inverse_link']};
	background-color: {$colors['text_link']};
}
#tribe-events-content .tribe-events-calendar td.mobile-active div[id*="tribe-events-daynum-"] {
	color: {$colors['bg_color']};
	background-color: {$colors['text_dark']};
}
#tribe-events-content .tribe-events-calendar td.tribe-events-othermonth.mobile-active div[id*="tribe-events-daynum-"] a,
.tribe-events-calendar .mobile-active div[id*="tribe-events-daynum-"] a {
	background-color: transparent;
	color: {$colors['bg_color']};
}

/* Tooltip */
.recurring-info-tooltip,
.tribe-events-calendar .tribe-events-tooltip,
.tribe-events-week .tribe-events-tooltip,
.tribe-events-tooltip .tribe-events-arrow {
	color: {$colors['alter_text']};
	background: {$colors['alter_bg_color']};
}
#tribe-events-content .tribe-events-tooltip h4 { 
	color: {$colors['text_link']};
	background: {$colors['text_dark']};
}
.tribe-events-tooltip .tribe-event-duration {
	color: {$colors['text_light']};
}

/* Events list */
.tribe-events-list-separator-month {
	color: {$colors['text_dark']};
}
.tribe-events-list-separator-month:after {
	border-color: {$colors['bd_color']};
}
.tribe-events-list .type-tribe_events + .type-tribe_events,
.tribe-events-day .tribe-events-day-time-slot + .tribe-events-day-time-slot + .tribe-events-day-time-slot {
	border-color: {$colors['bd_color']};
}
.tribe-events-list .tribe-events-event-cost span {
	color: {$colors['bg_color']};
	border-color: {$colors['text_dark']};
	background: {$colors['text_dark']};
}
.tribe-mobile .tribe-events-loop .tribe-events-event-meta {
	color: {$colors['alter_text']};
	border-color: {$colors['alter_bd_color']};
	background-color: {$colors['alter_bg_color']};
}
.tribe-mobile .tribe-events-loop .tribe-events-event-meta a {
	color: {$colors['alter_link']};
}
.tribe-mobile .tribe-events-loop .tribe-events-event-meta a:hover {
	color: {$colors['alter_hover']};
}
.tribe-mobile .tribe-events-list .tribe-events-venue-details {
	border-color: {$colors['alter_bd_color']};
}

/* Events day */
.tribe-events-day .tribe-events-day-time-slot h5 {
	color: {$colors['bg_color']};
	background: {$colors['text_dark']};
}

/* Single Event */
.single-tribe_events .tribe-events-venue-map {
	color: {$colors['alter_text']};
	border-color: {$colors['alter_bg_color']};
	background: {$colors['alter_bg_color']};
}
.single-tribe_events .tribe-events-schedule .tribe-events-cost {
	color: {$colors['text_dark']};
}
.single-tribe_events .type-tribe_events {
	border-color: {$colors['bd_color']};
}

.datepicker .datepicker-switch:hover, .datepicker .next:hover, .datepicker .prev:hover, .datepicker tfoot tr th:hover {
	background: {$colors['text_hover']};
}
.tribe-events-calendar td.tribe-events-othermonth.tribe-events-future div[id*=tribe-events-daynum-],
.tribe-events-calendar td div[id*="tribe-events-daynum-"], 
.tribe-events-calendar td.tribe-events-present div[id*="tribe-events-daynum-"], 
.tribe-events-calendar td.tribe-events-past div[id*="tribe-events-daynum-"] {
	background: {$colors['alter_bg_color']};
}
.tribe-events-calendar td.tribe-events-othermonth.tribe-events-future div[id*=tribe-events-daynum-], .tribe-events-calendar td.tribe-events-othermonth.tribe-events-future div[id*=tribe-events-daynum-]>a,
.tribe-events-calendar td div[id*="tribe-events-daynum-"], .tribe-events-calendar td div[id*="tribe-events-daynum-"] > a,
.tribe-events-calendar td.tribe-events-present div[id*="tribe-events-daynum-"], .tribe-events-calendar td.tribe-events-present div[id*="tribe-events-daynum-"] > a,
.tribe-events-calendar td.tribe-events-past div[id*="tribe-events-daynum-"], .tribe-events-calendar td.tribe-events-past div[id*="tribe-events-daynum-"] > a {
	color: {$colors['text_dark']};
}
#tribe-bar-form.tribe-bar-collapse #tribe-bar-collapse-toggle,
#tribe-bar-views-toggle,
#tribe-bar-views-toggle:focus,
#tribe-bar-views-toggle:hover {
    color: {$colors['extra_dark']} !important;
}


/* New Design */
.tribe-common a {
	color: {$colors['text_link']};
}
.tribe-common a:hover, 
.tribe-common a:active, 
.tribe-common a:focus{
	color: {$colors['text_hover']};
}

.tribe-events-calendar-day__event-datetime,
.tribe-events-calendar-list__event-datetime,
.tribe-events .tribe-events-calendar-month__calendar-event-tooltip-datetime {
	color: {$colors['text_link']};
}

.tribe-events .tribe-events-calendar-month__day-date-link {
	color: {$colors['text_hover']};
}
.tribe-events .tribe-events-calendar-month__day-date-link:hover {
	color: {$colors['text_link']};
}
.tribe-events-calendar-day__event-title.tribe-common-h6.tribe-common-h4--min-medium a,
.tribe-events-calendar-list__event-title .tribe-events-calendar-list__event-title-link,
.tribe-common .tribe-events-calendar-month__calendar-event-tooltip-title.tribe-common-h7 a{
	color: {$colors['text_hover']};
}
.tribe-events-calendar-day__event-title.tribe-common-h6.tribe-common-h4--min-medium a:hover,
.tribe-events-calendar-list__event-title .tribe-events-calendar-list__event-title-link:hover,
.tribe-common .tribe-events-calendar-month__calendar-event-tooltip-title.tribe-common-h7 a:hover {
	color: {$colors['text_link']};
}

.tribe-common--breakpoint-medium.tribe-events .tribe-events-c-view-selector--tabs .tribe-events-c-view-selector__list-item--active .tribe-events-c-view-selector__list-item-link:after {
	background: {$colors['text_link']};
}

.tribe-common .tribe-events-c-top-bar__datepicker-time .tribe-common-h3 {
	color: {$colors['text_link']};
}

.tribe-events .tribe-events-c-view-selector__list-item-text {
	color: {$colors['text_dark']};
}

.tribe-common .tribe-events-c-view-selector__list-item a:hover span,
.tribe-common .tribe-events-c-view-selector__list-item--active a span {
	color: {$colors['text_link']};
}

.tribe-events .datepicker .prev .tribe-common-svgicon:before,
.tribe-events .datepicker .next .tribe-common-svgicon:before {
	color: {$colors['bg_color']} ;
}

.tribe-events .datepicker .tribe-events-c-top-bar__datepicker-nav-icon-svg path:hover,
.tribe-events .datepicker .tribe-events-c-top-bar__datepicker-nav-icon-svg path{
	fill: {$colors['extra_link']}!important;
}

.tribe-common .tribe-events-c-nav__next, 
.tribe-common .tribe-events-c-nav__prev {
	background-color: {$colors['text_link']} ;
	color: {$colors['bg_color']} ;
}

.tribe-common--breakpoint-medium.tribe-events .tribe-events-c-nav__next:hover, 
.tribe-common--breakpoint-medium.tribe-events .tribe-events-c-nav__prev:hover{
	background-color: {$colors['text_hover']} ;
}

.tribe-common .tribe-common-c-btn.tribe-events-c-search__button {
	background-color: {$colors['text_link']} ;
}

.tribe-common .tribe-common-c-btn.tribe-events-c-search__button:hover {
	background-color: {$colors['text_hover']} ;
}

.tribe-common .tribe-common-c-btn-border, .tribe-common a.tribe-common-c-btn-border {
	color: {$colors['bg_color']};
	background-color: {$colors['text_link']} ;
	border-color: {$colors['text_link']} ;
}
.tribe-common .tribe-common-c-btn-border:focus, .tribe-common .tribe-common-c-btn-border:hover, 
.tribe-common .tribe-common-c-btn-border:active, .tribe-common .tribe-common-c-btn-border:focus-within, 
.tribe-common .tribe-common-c-btn-border:focus-visible,
.tribe-events .tribe-events-c-subscribe-dropdown .tribe-events-c-subscribe-dropdown__button.tribe-events-c-subscribe-dropdown__button--active,
.tribe-common a.tribe-common-c-btn-border:focus, .tribe-common a.tribe-common-c-btn-border:hover {
	color: {$colors['bg_color']};
	background-color: {$colors['text_hover']} ;
	border-color: {$colors['text_hover']} ;
}

.tribe-common--breakpoint-medium.tribe-events .tribe-events-calendar-month__day:hover:after {
	background-color: {$colors['text_link']};
}

.tribe-common .tribe-common-anchor-alt,
.tribe-events .tribe-events-c-ical__link  {
	color: {$colors['bg_color']};
	background-color: {$colors['text_link']};
}

.tribe-common .tribe-common-anchor-alt:hover,
.tribe-events .tribe-events-c-ical__link:active, 
.tribe-events .tribe-events-c-ical__link:focus, 
.tribe-events .tribe-events-c-ical__link:hover {
	color: {$colors['bg_color']};
	background-color: {$colors['text_hover']};
}

.tribe-events .tribe-events-c-events-bar__search-button, 
.tribe-events .tribe-events-c-view-selector__button { 
	background: transparent !important;
}

.tribe-common .tribe-common-svgicon--list:before,
.tribe-events .tribe-events-c-events-bar__search-button-icon:before {
	color: {$colors['text_link']};
}

.tribe-common .tribe-common-svgicon--list:hover:before,
.tribe-events .tribe-events-c-events-bar__search-button-icon:hover:before {
	color: {$colors['text_hover']};
}

.tribe-events .tribe-events-c-events-bar__search-button:before,
.tribe-events .tribe-events-c-view-selector__button:before {
	background-color: {$colors['text_hover']};
}

.tribe-common .tribe-events-calendar-month__day-cell .tribe-events-calendar-month__day-date.tribe-common-h4{
	color: {$colors['text_dark']};
}

.tribe-events .tribe-events-calendar-month__day-cell--mobile:focus, 
.tribe-events .tribe-events-calendar-month__day-cell--mobile:hover {
	background-color: {$colors['text_link']} !important;
}

.tribe-events .tribe-events-calendar-month__day-cell--mobile:focus .tribe-events-calendar-month__day-date-daynum, 
.tribe-events .tribe-events-calendar-month__day-cell--mobile:hover .tribe-events-calendar-month__day-date-daynum {
	color: {$colors['bg_color']};
}

.tribe-events .tribe-events-calendar-month__mobile-events-icon--event {
	background-color: {$colors['text_link']};
}

.tribe-events .tribe-events-calendar-month__day-cell--mobile:focus .tribe-events-calendar-month__mobile-events-icon--event, 
.tribe-events .tribe-events-calendar-month__day-cell--mobile:hover .tribe-events-calendar-month__mobile-events-icon--event {
	background-color: {$colors['bg_color']};
}

.tribe-common .tribe-events-view-loader__dots .tribe-common-c-loader__dot {
	background-color: {$colors['text_link']};
}

.tribe-common--breakpoint-medium.tribe-common .tribe-common-h3 {
	color: {$colors['bg_color']};
	background-color: {$colors['text_dark']};	
}
.tribe-common--breakpoint-medium.tribe-common .tribe-common-h3:hover {
	color: {$colors['bg_color']};
	background-color: {$colors['text_hover']};	
}

.tribe-common .tribe-events-c-top-bar__nav-list .tribe-common-c-btn-icon,
.tribe-common .tribe-events-c-top-bar__nav-list .tribe-common-c-btn-icon {
	color: {$colors['bg_color']};
	background-color: {$colors['text_hover']};
	border-color: {$colors['text_hover']};
}

.tribe-common .tribe-events-c-top-bar__nav-list .tribe-common-c-btn-icon:hover,
.tribe-common .tribe-events-c-top-bar__nav-list .tribe-common-c-btn-icon:hover {
	color: {$colors['bg_color']};
	background-color: {$colors['text_link']};
	border-color: {$colors['text_link']};
}

.tribe-common .tribe-events-c-top-bar__nav-list .tribe-common-c-btn-icon:before,
.tribe-common .tribe-events-c-top-bar__nav-list .tribe-common-c-btn-icon:after{
	color: {$colors['bg_color']};
}

.tribe-common .tribe-events-c-top-bar__nav-list .tribe-common-c-btn-icon:hover:before,
.tribe-common .tribe-events-c-top-bar__nav-list .tribe-common-c-btn-icon:hover:after{
	color: {$colors['bg_color']};	
}

.tribe-events .tribe-events-calendar-month__multiday-event-bar-inner {
	color: {$colors['bg_color']};
	background-color: {$colors['text_link_02']};	
}

.tribe-events .tribe-events-c-nav__prev:disabled,
.tribe-events .tribe-events-c-nav__next:disabled {
	color: {$colors['text']} !important;
}

.tribe-events .datepicker .datepicker-switch {
	color: {$colors['bg_color']};
}

.tribe-events .table-condensed th{
	color: {$colors['bg_color']};
}

.tribe-events .table-condensed th:hover{
	background-color: {$colors['text_link']} !important;
}

.tribe-events .datepicker .day.active, .tribe-events .datepicker .day.active.focused, 
.tribe-events .datepicker .day.active:focus, .tribe-events .datepicker .day.active:hover, 
.tribe-events .datepicker .month.active, .tribe-events .datepicker .month.active.focused, 
.tribe-events .datepicker .month.active:focus, .tribe-events .datepicker .month.active:hover, 
.tribe-events .datepicker .year.active, .tribe-events .datepicker .year.active.focused, 
.tribe-events .datepicker .year.active:focus, .tribe-events .datepicker .year.active:hover {
	background: {$colors['text_link']};
}

.tribe-events .datepicker .datepicker-switch:active, .tribe-events .datepicker .datepicker-switch:focus, 
.tribe-events .datepicker .datepicker-switch:hover, .tribe-events .datepicker .next:active, 
.tribe-events .datepicker .next:focus, .tribe-events .datepicker .next:hover, 
.tribe-events .datepicker .prev:active, .tribe-events .datepicker .prev:focus, 
.tribe-events .datepicker .prev:hover {
	background: {$colors['text_hover']};
}

.tribe-events .tribe-events-calendar-month__day--current .tribe-events-calendar-month__day-date, 
.tribe-events .tribe-events-calendar-month__day--current .tribe-events-calendar-month__day-date-link {
	color: {$colors['text_link']} ;
}

.tribe-common-h3.tribe-common-h--alt.tribe-events-c-top-bar__datepicker-button {
	color: {$colors['text_dark']};
	background-color: transparent;
}
.tribe-common-h3.tribe-common-h--alt.tribe-events-c-top-bar__datepicker-button:hover {
	color: {$colors['text_hover']} !important;
	background-color: transparent !important;
}

.tribe-events .tribe-events-c-small-cta__price {
	color: {$colors['text_link']} ;
}

.tribe-common .tribe-events-calendar-list__event-date-tag-daynum.tribe-common-h5 {
	color: {$colors['text_hover']} ;
}

.tribe-events-sub-nav li.tribe-events-nav-previous a,
.tribe-events-sub-nav li.tribe-events-nav-next a {
	background: {$colors['text_link']};
}

.tribe-events-sub-nav li.tribe-events-nav-previous a:hover,
.tribe-events-sub-nav li.tribe-events-nav-next a:hover {
	background: {$colors['text_hover']};
}

.tribe-events-c-nav__list-item.tribe-events-c-nav__list-item--prev .tribe-events-c-nav__prev,
.tribe-events-c-nav__list-item.tribe-events-c-nav__list-item--next .tribe-events-c-nav__next {
	color: {$colors['bg_color']};
	background-color: {$colors['text_link']} ;
}

.tribe-events-c-nav__list-item.tribe-events-c-nav__list-item--prev .tribe-events-c-nav__prev:hover,
.tribe-events-c-nav__list-item.tribe-events-c-nav__list-item--next .tribe-events-c-nav__next:hover {
	background-color: {$colors['text_hover']} ;
}


.tribe-events .tribe-events-calendar-month__header-column-title {
	color: {$colors['text_dark']};
}

.tribe-events .tribe-events-calendar-month__day {
	border-color: {$colors['bd_color']} ;
}
.tribe-common .tribe-events-calendar-month__day-cell.tribe-events-calendar-month__day-cell--mobile {
	border-color: {$colors['bd_color']} ;
	background: transparent;
}
.tribe-common .tribe-events-calendar-month__day-date-daynum {
	color: {$colors['text_hover']};
}
.tribe-common--breakpoint-medium.tribe-common .tribe-common-form-control-text__input{
	border-color: {$colors['input_bd_color']} ;
}
.tribe-common--breakpoint-medium.tribe-common .tribe-common-form-control-text__input:focus{
	border-color: {$colors['input_bd_hover']} ;
}

#tribe-events .tribe-events-cal-links a.tribe-events-gcal, 
#tribe-events .tribe-events-cal-links a.tribe-events-ical {
	background-color: {$colors['text_hover']} ;
}
#tribe-events .tribe-events-cal-links a.tribe-events-gcal:hover, 
#tribe-events .tribe-events-cal-links a.tribe-events-ical:hover {
	background-color: {$colors['text_link']} ;
}

.tribe-common--breakpoint-medium.tribe-common .tribe-common-b3 {
	color: {$colors['text_dark']} ;
}

.tribe-common .tribe-common-anchor-thin-alt {
	border-color: {$colors['text_link']} ;
}
.tribe-common .tribe-common-anchor-thin-alt:hover {
	border-color: {$colors['text_hover']} ;
}

.single-tribe_events .tribe-events-single .tribe-events-event-meta,
.tribe-events-content{
	color: {$colors['text']} ;
}

.tribe-events-meta-group .tribe-events-single-section-title{
	color: {$colors['text_dark']};
}

.tribe-events-event-meta a{
	color: {$colors['text_link']};
}

.tribe-events-event-meta a:focus, 
.tribe-events-event-meta a:hover{
	color: {$colors['text_hover']};
}

CSS;
		}
		
		return $css;
	}
}
?>