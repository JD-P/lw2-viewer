<?php
	header ('Content-type: text/css; charset=utf-8');
	
	$platform = @$argv[1] ?: 'Mac';
	$UI_font = ($platform == 'Windows') ? "'Whitney', 'a_Avante'" : "'Concourse', 'a_Avante'";
?>

<?php echo file_get_contents('fa-custom.css'); ?>

/***************/
/* BASE LAYOUT */
/***************/

html {
	box-sizing: border-box;
	font-size: 16px;
}
*, *::before, *::after {
	box-sizing: inherit;
}
:focus {
	outline: none;
}
body {
	padding: 0;
	margin: 0;
}
body::before {
	background-color: inherit;
	position: fixed;
	width: 100%;
	height: 100%;
}
input {
	font-family: inherit;
	font-size: inherit;
	font-weight: inherit;
}
#content {
	margin: 0 auto;
	padding: 0 30px;
	overflow: auto;
	max-width: 900px;
	position: relative;
}

/***********/
/* NAV BAR */
/***********/

.nav-bar {
	margin: 0 -30px;
}
.nav-bar {
	display: flex;
}
.nav-item {
	flex: 1 1 auto;
}
.nav-item * {
	text-overflow: ellipsis;
	white-space: nowrap;
	overflow: hidden;
}
.nav-inner {
	padding: 12px 30px;
	font-size: 1.375em;
	text-align: center;
	display: block;
	position: relative;
}
#primary-bar.inactive-bar .nav-inner {
	padding-top: 11px;
	padding-bottom: 13px;
}
.nav-inner::after {
	content: attr(accesskey);
	display: none;
}
#secondary-bar .nav-inner {
	font-size: 1em;
	padding: 4px 0;
}
#bottom-bar .nav-item {
	flex: 1 1 0;
}

#bottom-bar .nav-item a::before,
#top-nav-bar a::before {
	font-family: Font Awesome;
	font-weight: 900;
	font-size: 0.8em;
	position: relative;
	bottom: 1px;
	margin-right: 0.5em;
}
#bottom-bar #nav-item-first a::before,
#top-nav-bar a.nav-item-first::before {
	content: "\F100";
}
#bottom-bar #nav-item-top a::before {
	content: "\F062";
}
#bottom-bar #nav-item-prev a::before,
#top-nav-bar a.nav-item-prev::before {
	content: "\F060";
}
#bottom-bar #nav-item-next a::before,
#top-nav-bar a.nav-item-next::before {
	content: "\F061";
}
#bottom-bar #nav-item-next a::before {
	margin-left: -2em;
	margin-right: 0;
	left: 3.8em;
}

/* Search tab */

#nav-item-search {
	flex: 4 1 auto;
}
#nav-item-search form::before {
	content: "\F002";
	font-family: Font Awesome;
	display: inline-block;
	vertical-align: top;
	height: 23px;
	width: 23px;
}
#nav-item-search input {
	height: 23px;
	width: calc(95% - 80px);
	padding: 1px 4px;
}
#nav-item-search button {
	height: 21px;
}

/* Login tab */

#nav-item-login {
	position: relative;
	padding-right: 0.5em;
}

/*******************/
/* INBOX INDICATOR */
/*******************/

#inbox-indicator {
	position: absolute;
	top: 1px;
	right: 0;
	height: 100%;
	visibility: hidden;
}
#inbox-indicator::before {
	content: "\F0E0";
	font-family: "Font Awesome";
	color: #bbb;
	font-size: 1.1875rem;
	position: absolute;
	height: 100%;
	right: 0;
	top: 0;
	padding: 0 0.45em;
	visibility: visible;
	z-index: 1000;
	font-weight: 900;
}
#inbox-indicator.new-messages::before {
	color: #f00;
	text-shadow: 
		0 0 1px #777,
		0.5px 0.5px 1px #777;
}
a#inbox-indicator:hover::before {
	color: #fff;
	text-shadow: 
		0 0 1px #000,
		0 0 2px #000,
		0 0 4px #000,
		0 0 1px #777,
		0.5px 0.5px 1px #777;
}
a#inbox-indicator.new-messages:hover::before {
	text-shadow: 
		0 0 1px #f00,
		0 0 2px #f00,
		0 0 4px #f00,
		0 0 1px #777,
		0.5px 0.5px 1px #777;
}

/****************/
/* PAGE TOOLBAR */
/****************/

.page-toolbar {
	position: absolute;
	font-size: 0.9em;
	right: 0.4em;
	line-height: 1.8;
}
.page-toolbar > * {
	display: inline-block;
	margin-left: 1.5em;
}
.page-toolbar .button::before {
	font-family: "Font Awesome";
	font-size: 0.9em;
	padding-right: 0.3em;
}
.new-post::before {
	content: '\F067';
	font-weight: 900;
}
.new-private-message::before {
	content: '\F075';
	font-weight: 400;
}
.logout-button::before {
	content: '\F2F5';
	font-weight: 900;
}
.rss::before {
	content: url('data:image/svg+xml;base64,<?php echo base64_encode(file_get_contents("assets/rss.svg")) ?>');
	display: inline-block;
	width: 1em;
	padding-right: 0.2em;
	position: relative;
	top: 1px;
}

/*********************/
/* TOP PAGINATION UI */
/*********************/

#top-nav-bar {
	margin: 0.5em 0 -1.5em 0;
	padding: 0.75em 0 0 0;
	text-align: center;
	font-size: 1.25em;
}
.sublevel-nav + #top-nav-bar {
	margin-top: 0.25em;
}
.sublevel-nav + #top-nav-bar + h1.listing {
	margin-top: 1.5em;
}
.archive-nav + #top-nav-bar {
	margin-top: 1em;
}
.archive-nav + #top-nav-bar + h1.listing {
	margin-top: 1em;
}
#top-nav-bar a.disabled {
	pointer-events: none;
	visibility: hidden;
}
#top-nav-bar a.nav-item-last::before {
	content: "\2002";
}
#top-nav-bar .page-number {
	position: relative;
	display: inline-block;
	width: 1.5em;
}
#top-nav-bar .page-number-label {
	position: absolute;
	font-size: 0.5em;
	text-transform: uppercase;
	width: 100%;
	bottom: 90%;
	left: 0;
}
#top-nav-bar a::before {
	margin: 0.5em;
	display: inline-block;
}

/****************/
/* SUBLEVEL NAV */
/****************/

.sublevel-nav {
	text-align: center;
	margin: 0;
}
.sublevel-nav .sublevel-item {
	display: inline-block;
	width: 6em;
	padding: 0.125em;
	text-align: center;
	font-size: 1.125rem;
}
.sublevel-nav span.sublevel-item {
	cursor: default;
}

/***********************/
/* SORT ORDER SELECTOR */
/***********************/

.sublevel-nav.sort {
	position: absolute;
	top: 167px;
	right: 30px;
	font-size: 0.75em;
}
.sublevel-nav.sort::before {
	content: "Sort";
	position: absolute;
	top: 0;
	left: 0;
	width: 100%;
}
.sublevel-nav.sort .sublevel-item {
	width: unset;
	line-height: 1;
	display: block;
	font-size: 1.125em;
}

/******************/
/* WIDTH SELECTOR */
/******************/

#width-selector {
	position: fixed;
	top: 4px;
	right: calc((100% - 900px) / 2 - 78px);
}
#width-selector button {
	color: transparent;
	width: 22px;
	height: 22px;
	padding: 6px;
	margin: 1px;
	overflow: hidden;
	background-repeat: no-repeat;
	background-size: 100%;
	background-origin: content-box;
}
#width-selector button:disabled {
	cursor: auto;
}
#width-selector button.select-width-normal {
	background-image: url('data:image/gif;base64,<?php echo base64_encode(file_get_contents("assets/normal.gif")) ?>');
}
#width-selector button.select-width-wide {
	background-image: url('data:image/gif;base64,<?php echo base64_encode(file_get_contents("assets/wide.gif")) ?>');
}
#width-selector button.select-width-fluid {
	background-image: url('data:image/gif;base64,<?php echo base64_encode(file_get_contents("assets/fluid.gif")) ?>');
}

/******************/
/* THEME SELECTOR */
/******************/

#theme-selector {
	position: fixed;
	top: 3px;
	left: calc((100% - 900px) / 2 - 41px);
	opacity: 0.4;
	display: table;
	max-width: 40px;
}
#theme-selector:hover {
	opacity: 1.0;
}

.theme-selector button {
	display: table-cell;
	width: 26px;
	height: 26px;
	padding: 0;
	text-align: center;
	vertical-align: middle;
	margin: 1px 7px 0 7px;
	font-size: 0.75rem;
	position: relative;
}
.theme-selector button:disabled {
	cursor: auto;
}

/*******************/
/* QUICKNAV WIDGET */
/*******************/

#quick-nav-ui {
	position: fixed;
	right: calc((100vw - 900px) / 2 - 75px);
	bottom: 20px;
}
#quick-nav-ui a {
	font-family: 'Font Awesome';
	font-weight: 900;
	line-height: 1.7;
	text-align: center;
	display: block;
	width: 40px;
	height: 40px;
	margin: 10px 0 0 0;
}
#quick-nav-ui a[href='#comments'].no-comments {
	pointer-events: none;
}

/************************/
/* NEW COMMENT QUICKNAV */
/************************/

#new-comment-nav-ui {
	position: fixed;
	right: calc((100vw - 900px) / 2 - 120px);
	bottom: 42px;
}
#new-comment-nav-ui > * {
	display: block;
	position: relative;
}
#new-comment-nav-ui .new-comments-count {
	width: 2em;
	font-size: 1.25rem;
	line-height: 1.1;
	text-align: center;
	left: 1px;
	cursor: pointer;
}
#new-comment-nav-ui .new-comments-count::selection {
	background-color: transparent;
}
#new-comment-nav-ui .new-comments-count::after {
	content: "NEW";
	display: block;
	font-size: 0.625rem;
}
#new-comment-nav-ui .new-comment-sequential-nav-button {
	font-size: 1.75rem;
	font-family: 'Font Awesome';
	font-weight: 900;
	width: 1.5em;
	z-index: 5001;
}
#new-comment-nav-ui .new-comment-previous {
	top: 8px;
}
#new-comment-nav-ui .new-comment-next {
	bottom: 6px;
}
#new-comment-nav-ui .new-comment-sequential-nav-button:disabled {
	cursor: auto;
}

/*******************/
/* HNS DATE PICKER */
/*******************/

#hns-date-picker {
	position: fixed;
	bottom: 72px;
	right: calc((100vw - 900px) / 2 - 261px);
	opacity: 0.6;
}
@media only screen and (max-width: 1440px) {
	#hns-date-picker {
		right: calc((100vw - 900px) / 2 - 88px);
		z-index: 10001;
		padding: 8px 10px 10px 10px;
		bottom: 62px;
		display: none;
	}
	#hns-date-picker::before {
		content: "";
		position: absolute;
		display: block;
		z-index: -1;
		height: calc(100% + 2px);
		top: -1px;
		left: -1px;
		width: 50%;
	}
}
#hns-date-picker:hover, 
#hns-date-picker:focus-within {
	opacity: 1.0;
}
#hns-date-picker span {
	display: block;
	font-size: 0.75rem;
	text-transform: uppercase;
}
#hns-date-picker input {
	margin-top: 1px;
	padding: 1px 3px;
	width: 140px;
	text-align: center;
}

/************************/
/* TEXT SIZE ADJUSTMENT */
/************************/

#text-size-adjustment-ui {
	position: fixed;
	top: 30px;
	right: calc((100% - 900px) / 2 - 78px);
	opacity: 0.4;
}
#text-size-adjustment-ui:hover {
	opacity: 1.0;
}
#text-size-adjustment-ui button {
	font-weight: 900;
	font-family: Font Awesome;
	font-size: 0.75rem;
	width: 24px;
	height: 24px;
	padding: 0;
}
#text-size-adjustment-ui button.default {
	font-family: inherit;
	font-size: 1.125rem;
	position: relative;
	top: 1px;
}
#text-size-adjustment-ui button:disabled {
	opacity: 0.5;
}
#text-size-adjustment-ui button:disabled:hover {
	cursor: default;
}
/* This doesn't work in Mozilla browsers, so hide it */
@-moz-document url-prefix() {
	#text-size-adjustment-ui {
		display: none;
	}
}

/*******************************/
/* COMMENTS VIEW MODE SELECTOR */
/*******************************/

#comments-view-mode-selector {
	position: fixed;
	bottom: 30px;
	left: calc((100% - 900px) / 2 - 40px);
	opacity: 0.6;
}
#comments-view-mode-selector:hover {
	opacity: 1.0;
}
#comments-view-mode-selector a {
	display: block;
	font-family: Font Awesome;
	font-size: 1.25rem;
	text-align: center;
	opacity: 0.4;
	padding: 0.25em;
	z-index: 1;
}
#comments-view-mode-selector a.threaded {
	transform: scaleY(-1);
	font-weight: 900;
}
#comments-view-mode-selector a.chrono {
	font-weight: normal;
}
#comments-view-mode-selector a.selected,
#comments-view-mode-selector a:hover {
	opacity: 1.0;
	text-decoration: none;
}
#comments-view-mode-selector a.selected {
	cursor: default;
}

/************/
/* ARCHIVES */
/************/

.archive-nav {
	margin: 1.25em 0.5em -1.25em;
	padding: 0.25em;
}
.archive-nav > * {
	display: flex;
}
.archive-nav *[class^='archive-nav-item'] {
	line-height: 1;
	flex: 1 1 5%;
	text-align: center;
	padding: 6px 4px 4px 4px;
	max-width: 8%;
}
@-moz-document url-prefix() {
	.archive-nav *[class^='archive-nav-item'] {
		padding: 5px 4px;
	}
}
.archive-nav-days .archive-nav-item-day {
	font-size: 0.8em;
	padding: 7px 0 5px 0;
	max-width: 4%;
}
.archive-nav-days .archive-nav-item-day:first-child {
	flex-basis: 10%;
}

/************/
/* LISTINGS */
/************/

h1.listing {
	margin: 0.7em 20px 0.1em 20px;
	font-size: 1.875rem;
	line-height: 1.15;
}
@media only screen and (min-width: 901px) and (hover: hover) {
	h1.listing {
		max-height: 1.15em;
	}
}
@-moz-document url-prefix() {
	h1.listing {
		max-height: 1.15em;
	}
}
h1.listing:first-of-type {
	margin-top: 1.25em;
}

h1.listing a {
	position: relative;
}
h1.listing a:nth-of-type(2) {
	margin-left: 0.25em;
}
@media only screen and (min-width: 901px) and (hover: hover) {
	h1.listing a {
		max-width: 100%;
		display: inline-block;
		white-space: nowrap;
		text-overflow: ellipsis;
		overflow: hidden;
		border-bottom: 1px solid transparent;
		-moz-hyphens: auto;
		-ms-hyphens: auto;
		hyphens: auto;
		z-index: 1;
		padding: 0 0 1px 1px;
	}
	h1.listing a:nth-of-type(2) {
		max-width: calc(100% - 33px);
	}
}
@-moz-document url-prefix() {
	h1.listing a {
		max-width: 100%;
		display: inline-block;
		white-space: nowrap;
		text-overflow: ellipsis;
		overflow: hidden;
		border-bottom: 1px solid transparent;
		-moz-hyphens: auto;
		-ms-hyphens: auto;
		hyphens: auto;
		z-index: 1;
		padding: 0 0 1px 1px;
	}
	h1.listing a:nth-of-type(2) {
		max-width: calc(100% - 33px);
	}
}
h1.listing a[href^="http"] {
	font-size: 0.8em;
	display: inline;
	vertical-align: top;
	position: relative;
	top: 4px;
}
@media only screen and (hover: hover) {
	h1.listing a:hover,
	h1.listing a:focus {
		text-decoration: dotted underline;
		white-space: initial;
		background-color: rgba(255,255,255,0.85);
		z-index: 2;
	}	
	h1.listing:focus-within::before {
		content: ">";
		display: block;
		position: absolute;
		left: 1em;
	}

	<?php $margin_of_hover_error = '10px'; ?>
	h1.listing a:hover::before {
		content: "";
		position: absolute;
		top: -<?php echo $margin_of_hover_error; ?>;
		right: -<?php echo $margin_of_hover_error; ?>;
		bottom: -<?php echo $margin_of_hover_error; ?>;
		left: -<?php echo $margin_of_hover_error; ?>;
		z-index: -1;
	}
	h1.listing a[href^="http"]:hover {
		text-decoration: none;
	}
}
@-moz-document url-prefix() {
	h1.listing a:hover,
	h1.listing a:focus {
		text-decoration: dotted underline;
		white-space: initial;
		background-color: rgba(255,255,255,0.85);
		z-index: 2;
	}	
	h1.listing:focus-within::before {
		content: ">";
		display: block;
		position: absolute;
		left: 1em;
	}

	<?php $margin_of_hover_error = '10px'; ?>
	h1.listing a:hover::before {
		content: "";
		position: absolute;
		top: -<?php echo $margin_of_hover_error; ?>;
		right: -<?php echo $margin_of_hover_error; ?>;
		bottom: -<?php echo $margin_of_hover_error; ?>;
		left: -<?php echo $margin_of_hover_error; ?>;
		z-index: -1;
	}
	h1.listing a[href^="http"]:hover {
		color: #4879ec;
		text-decoration: none;
	}
}

.listing-message {
	width: 100%;
	text-align: center;
	padding: 1.25em 0 1.25em 0;
	font-size: 1.375em;
}
.archive-nav + .listing-message {
	padding: 1.75em 0 1.25em 0;
}

h1.listing + .post-meta {
	text-align: left;
	margin: 0 20px 0 21px;
}
h1.listing:last-of-type + .post-meta {
	margin-bottom: 1.25em;
}

h1.listing + .post-meta .post-section {
	width: 0;
	margin: -0.5em;
	overflow: hidden;
}
h1.listing + .post-meta .post-section::before {
	position: absolute;
	left: -28px;
}

/**************/
/* USER PAGES */
/**************/

#content.user-page h1.page-main-heading {
	margin: 1em 0 0.75em 0;
	line-height: 1.2;
}
#content.user-page .user-stats {
	float: right;
	margin-top: -3.1em;
}

/*****************/
/* CONVERSATIONS */
/*****************/

#content.conversation-page .conversation-participants {
	margin: 3em 0 0;
}

.conversation-participants ul,
.conversation-participants li {
	list-style-type: none;
	display: inline-block;
	margin: 0;
	padding: 0;
}
.conversation-participants li {
	margin-left: 1em;
}
#content.conversation-page .posting-controls {
	margin: 0.5em 0 4em;
	padding-bottom: 1em;
}
#content.conversation-page .post-meta-fields {
	overflow: auto;
}
#content.conversation-page textarea {
	border-top-width: 1px;
	margin-top: 0.25em;
}
#content.conversation-page h1.page-main-heading {
	text-align: center;
	margin: 0.5em 0 0 0;
}
#conversation-form input[type='text'],
#conversation-form label {
	margin: 0.25em 0;
}
#conversation-form label {
	width: 6em;
}
#conversation-form input[type='text'] {
	width: calc(100% - 6em);
}
#conversation-form input[type='submit'] {
	float: right;
}

/*********************************/
/* SEARCH RESULTS AND USER PAGES */
/*********************************/

#content.search-results-page h1.listing,
#content.user-page h1.listing {
	font-size: 1.625em;
}
#content.search-results-page .post-meta,
#content.user-page .post-meta {
	font-size: 1rem;
}
#content.search-results-page #secondary-bar + * {
	margin-top: 3.5rem;
}

/**************/
/* LOGIN PAGE */
/**************/

.login-container {
	margin: 3em 0 4em;
	display: flex;
	flex-flow: row wrap;
}

.login-container form {
	width: 50%;
	display: flex;
	flex-flow: row wrap;
	align-items: baseline;
	align-content: flex-start;
}
.login-container form label {
	text-align: right;
	padding: 0.25em 0.5em;
	white-space: nowrap;
	margin: 0 0 0.25em 0;
}
.login-container form input {
	width: calc(100% - 11em);
	padding: 0.25em;
}
.login-container form input[type='submit'],
.login-container form a {
	text-align: center;
}
.login-container form input[type='submit'] {
	width: 11em;
	padding: 0.35em;
	margin: 0.5em auto;
	line-height: 1;
}
.login-container form a {
	width: 100%;
}
.login-container form h1 {
	text-align: center;
	margin: 0.5em 0;
	width: 100%;
}

/* “Log in” form */

#login-form h1 {
	padding-left: 2rem;
}
#login-form label {
	width: 7em;
}
#login-form input[type='submit'],
#login-form a {
	position: relative;
	left: 1.375em;
}

/* “Create account” form */

#signup-form {
	font-size: 0.9em;
	width: calc(50% - 1em);
	margin-right: 1em;
}
#signup-form h1 {
	font-size: 1.7em;
}
#signup-form label {
	width: 9em;
}
#signup-form input[type='submit'] {
	margin: 0.75em auto 0.5em auto;
	padding: 0.4em 0.5em 0.5em 0.5em;
	position: relative;
	left: 3.5em;
}

/* Log in tip */

.login-container .login-tip {
	padding: 0.5em 0.5em 0.5em 3em;
	margin: 2em 4em 0 4em;
	text-indent: -2em;
	line-height: 1.4;
}
.login-container .login-tip span {
	font-weight: bold;
}

/* Message box */

#content.login-page .error-box {
	margin: 1.5em 0.875em -1.5em 0.875em;
}
.error-box, .success-box {
	padding: 0.25em;
	text-align: center;
}

/***********************/
/* PASSWORD RESET PAGE */
/***********************/

.reset-password-container {
	margin-bottom: 2em;
}
.reset-password-container input[type='submit'] {
	padding: 0.2em 0.5em;
	width: unset;
}
.reset-password-container input {
	margin-left: 0.5em;
	width: 12em;
}
.reset-password-container label {
	display: inline-block;
	width: 9em;
}
.reset-password-container form > div {
	margin: 0.2em;
}
.reset-password-container .action-container {
	padding-left: 11em;
	padding-top: 0.2em;
}
.reset-password-container .error-box {
	margin: unset;
}

/*********************/
/* TABLE OF CONTENTS */
/*********************/

.contents {
	float: right;
	min-width: 12em;
	max-width: 40%;
	margin: 1.25em 0 0.75em 1.25em;
	padding: 0.35em 0.35em 0.4em 0.35em;
	-webkit-hyphens: none;
	-ms-hyphens: none;
	hyphens: none;
}

.contents-head {
	text-align: center;
	margin-bottom: 0.25em;
}

.post-body .contents ul {
	list-style-type: none;
	margin: 0 0 0 0.5em;
	counter-reset: toc-item-1 toc-item-2 toc-item-3;
	padding-left: 1em;
	font-size: 0.75em;
}
.post-body .contents li {
	margin: 0.15em 0 0.3em 1em;
	text-align: left;
	text-indent: -1em;
	line-height: 1.2;
	position: relative;
}
.post-body .contents li::before {
	position: absolute;
	width: 3em;
	display: block;
	text-align: right;
	left: -4.5em;
}
.contents .toc-item-1 {
	counter-increment: toc-item-1;
	counter-reset: toc-item-2 toc-item-3;
}
.contents .toc-item-1::before {
	content: counter(toc-item-1);
}
.contents .toc-item-1 ~ .toc-item-2 {
	margin-left: 2.9em;
	font-size: 0.95em;
}
.contents .toc-item-2 {
	counter-increment: toc-item-2;
	counter-reset: toc-item-3;
}
.contents .toc-item-1 ~ .toc-item-2::before {
	content: counter(toc-item-1) "." counter(toc-item-2);
}
.contents .toc-item-2::before {
	content: counter(toc-item-2);
}
.contents .toc-item-1 + .toc-item-3 {
	counter-increment: toc-item-2 toc-item-3;
}
.contents .toc-item-2 ~ .toc-item-3,
.contents .toc-item-1 ~ .toc-item-3 {
	margin-left: 2.9em;
	font-size: 0.95em;
}
.contents .toc-item-1 ~ .toc-item-2 ~ .toc-item-3 {
	margin-left: 5.7em;
	font-size: 0.9em;
}
.contents .toc-item-3 {
	counter-increment: toc-item-3;
}
.contents .toc-item-1 ~ .toc-item-2 ~ .toc-item-3::before {
	content: counter(toc-item-1) "." counter(toc-item-2) "." counter(toc-item-3);
}
.contents .toc-item-1 ~ .toc-item-3::before {
	content: counter(toc-item-1) "." counter(toc-item-3);
}
.contents .toc-item-2 ~ .toc-item-3::before {
	content: counter(toc-item-2) "." counter(toc-item-3);
}
.contents .toc-item-3::before {
	content: counter(toc-item-3);
}
.contents .toc-item-4,
.contents .toc-item-5,
.contents .toc-item-6 {
	display: none;
}

/********************/
/* POSTS & COMMENTS */
/********************/

.post-meta > *,
.comment-meta > * {
	display: inline-block;
	margin-right: 1em;
	font-size: 1.0625em;
	white-space: nowrap;
}
.post-body, .comment-body {
	text-align: justify;
	-webkit-hyphens: auto;
	-ms-hyphens: auto;
	hyphens: auto;
}
.post-body p, .comment-body p {
	margin: 1em 0;
}

/*************/
/* POST-META */
/*************/

.post-meta {
/* 	position: relative; */
}
.post-meta .post-section {
	margin: 0;
	visibility: hidden;
}
.post-meta .post-section::before {
	visibility: visible;
	font-family: "Font Awesome";
	font-weight: 900;
}
.post-meta .link-post-domain {
	margin-left: 1em;
}
.post-meta .read-time {
	cursor: default;
}
.post-section.frontpage::before {
	content: "\F015";
}
.post-section.featured::before {
	content: "\F005";
}
.post-section.meta::before {
	content: "\F077";
}
.post-section.personal::before {
	content: "\F007";
}
.post-section.draft::before {
	content: "\F15B";
}

/*********/
/* POSTS */
/*********/

.post-body {
	min-height: 8em;
	padding: 0 30px;
	line-height: 1.5;
	font-size: 1.3rem;
	overflow: auto;
	margin: 0.5em 0 0 0;
}
.post > h1:first-child {
	margin: 1.1em 0 0.35em 0;
	padding: 0 30px;
	text-align: center;
	font-size: 2.5em;
	line-height: 1;
}
.post .post-meta {
	text-align: center;
}
.post .top-post-meta:last-child {
	margin-bottom: 40px;
}
.post .bottom-post-meta {
	margin: 0;
	padding: 20px 0 22px 0;
}

/**************/
/* LINK POSTS */
/**************/

.post.link-post > .post-body > p:first-child {
	text-align: center;
	font-size: 1.125em;
	margin: 0.5em 0 0 0;
}
.post.link-post > .post-body > p:only-child {
	font-size: 1.5em;
	margin: 1em 0;
}
.post.link-post a.link-post-link::before {
	content: "\F0C1";
	font-family: Font Awesome;
	font-weight: 900;
	font-size: 0.75em;
	position: relative;
	top: -2px;
	margin-right: 0.25em;
}

/************/
/* COMMENTS */
/************/

#comments {
	padding: 0 0 1px 0;
}
ul.comment-thread {
	list-style-type: none;
	padding: 0;
}
#comments .comment-thread > li {
	position: relative;
}

.comment-item {
	margin: 2em 0 0 0;
}
.comment-item .comment-item {
	margin: 1em 8px 8px 16px;
}
.comment-item .comment-item + .comment-item {
	margin: 2em 8px 8px 16px;
}

.comment-body {
	line-height: 1.45;
	font-size: 1.2rem;
	padding: 10px;
}
.comment-body ul {
	list-style-type: circle;
}
.comment-body > *:first-child {
	margin-top: 0;
}
.comment-body > *:last-child {
	margin-bottom: 0;
}

#comments:empty::before,
#comments > .comment-controls:last-child::after {
	content: "No comments.";
	display: block;
	width: 100%;
	text-align: center;
	padding: 0.75em 0 0.9em 0;
	font-size: 1.375em;
}

/**********************************/
/* DEEP COMMENT THREAD COLLAPSING */
/**********************************/

.comment-item input[id^="expand"] {
	display: none;
}
.comment-item input[id^="expand"] + label {
	display: block;
	visibility: hidden;
	position: relative;
	margin: 8px 9px;
}
.comment-item input[id^="expand"] + label::after {
	content: "(Expand " attr(data-child-count) "	below)";
	visibility: visible;
	position: absolute;
	left: 0;
	white-space: nowrap;
	cursor: pointer;
}
.comment-item input[id^="expand"]:checked + label::after {
	content: "(Collapse " attr(data-child-count) "	below)";
}
.comment-item input[id^="expand"] ~ .comment-thread {
	max-height: 34px;
	overflow: hidden;
}
.comment-item input[id^="expand"] ~ .comment-thread > li:first-child {
	margin-top: 0;
}
.comment-item input[id^="expand"]:checked ~ .comment-thread {
	max-height: 1000000px;
}

.comment-item input[id^="expand"]:checked ~ .comment-thread .comment-thread .comment-item {
	margin: 0;
}
.comment-item input[id^="expand"]:checked ~ .comment-thread .comment-thread .comment-item a.comment-parent-link:hover::after {
	display: none;
}

/****************/
/* COMMENT-META */
/****************/

.comment-meta {
	padding: 2px 80px 2px 10px;
	margin: 0 -1px;
	border: none;
	display: flex;
	flex-flow: row wrap;
	align-items: baseline;
}
.comment-meta .comment-post-title {
	flex-basis: 100%;
	overflow: hidden;
	text-overflow: ellipsis;
}
.user-page .comment-meta {
	padding-right: 10px;
}

/*****************************/
/* COMMENT THREAD NAVIGATION */
/*****************************/

a.comment-parent-link {
	opacity: 0.5;
}
a.comment-parent-link:hover {
	opacity: 1.0;
}
a.comment-parent-link::before {
	content: "\F062";
	font-family: "Font Awesome";
	font-weight: 900;
	font-size: 0.75rem;
	line-height: 1;
	position: absolute;
	z-index: 1;
	display: block;
	padding: 3px 3px 0 3px;
	width: 16px;
	height: calc(100% + 2px);
	top: -1px;
	left: -17px;
}
a.comment-parent-link::after {
	content: "";
	position: absolute;
	z-index: 0;
	display: block;
	width: calc(100% + 26px);
	height: calc(100% + 38px);
	top: -29px;
	left: -17px;
	pointer-events: none;
	overflow: hidden;
	visibility: hidden;
}
a.comment-parent-link:hover::after {
	visibility: visible;
}

div.comment-child-links {
	display: block;
}
div.comment-child-links a {
	margin: 0 0.2em;
	display: inline-block;
}
div.comment-child-links a::first-letter {
	margin: 0 1px 0 0;
}

.comment-popup {
	position: fixed;
	top: 10%;
	right: 10%;
	max-width: 700px;
	z-index: 10000;
	font-size: 1rem;
	white-space: unset;
	pointer-events: none;
}
.comment-popup .comment-parent-link {
	display: none;
}
.comment-popup .comment-body {
	font-size: 1.0625rem;
}

/**********************/
/* COMMENT PERMALINKS */
/**********************/
/********************/
/* COMMENT LW LINKS */
/********************/

.comment-meta .permalink::before,
.comment-meta .lw2-link::before,
.individual-thread-page a.comment-parent-link:empty::before {
	content: "";
	display: inline-block;
	width: 1rem;
	height: 1rem;
	border-radius: 3px;
	box-shadow: 
		0 0 0 1px #fff,
		0 0 0 2px #00e,
		0 0 0 3px transparent;
	padding: 0 0 0 2px;
	background-size: 100%;
	position: relative;
	top: 2px;
	opacity: 0.5;
}
.comment-meta .permalink::before {
	background-image: url('data:image/gif;base64,<?php echo base64_encode(file_get_contents("assets/anchor-white-on-blue.gif")) ?>');
}
.comment-meta .lw2-link::before {
	background-image: url('data:image/gif;base64,<?php echo base64_encode(file_get_contents("assets/lw-white-on-blue.gif")) ?>');
}
.individual-thread-page a.comment-parent-link:empty::before {
	left: unset;
	background-image: url('data:image/gif;base64,<?php echo base64_encode(file_get_contents("assets/up-arrow-white-on-blue.gif")) ?>');
}
.comment-meta .permalink:hover::before {
	background-image: url('data:image/gif;base64,<?php echo base64_encode(file_get_contents("assets/anchor-blue-on-white.gif")) ?>');
}
.comment-meta .lw2-link:hover::before {
	background-image: url('data:image/gif;base64,<?php echo base64_encode(file_get_contents("assets/lw-blue-on-white.gif")) ?>');
}
.individual-thread-page a.comment-parent-link:empty:hover::before {
	background-image: url('data:image/gif;base64,<?php echo base64_encode(file_get_contents("assets/up-arrow-blue-on-white.gif")) ?>');
}
.comment-meta .permalink:hover::before,
.comment-meta .lw2-link:hover::before,
.individual-thread-page a.comment-parent-link:empty:hover::before {
	box-shadow: 
		0 0 0 2px #00e,
		0 0 0 3px transparent;
}
.comment-meta .permalink:active::before,
.comment-meta .lw2-link:active::before,
.individual-thread-page a.comment-parent-link:empty:active::before {
	transform: scale(0.9);
}

.comment-meta .permalink,
.comment-meta .lw2-link,
.individual-thread-page .comment-parent-link:empty {
	position: relative;
	opacity: 1.0;
}
.comment-meta .permalink::after,
.comment-meta .lw2-link::after,
.individual-thread-page .comment-parent-link:empty::after {
	content: "";
	width: 30px;
	height: 30px;
	display: block;
	position: absolute;
	top: -2px;
	left: -7px;
	box-shadow: none;
	pointer-events: auto;
	visibility: visible;
}

/*************************/
/* COMMENTS COMPACT VIEW */
/*************************/

#comments-list-mode-selector {
	position: absolute;
	top: 108px;
	left: calc((100% - 900px) / 2 + 29px);
}
#content.user-page + #ui-elements-container #comments-list-mode-selector,
#content.conversation-page + #ui-elements-container #comments-list-mode-selector {
	top: 165px;
}
#content.search-results-page + #ui-elements-container #comments-list-mode-selector {
	top: 95px;
}
#comments-list-mode-selector button {
	color: transparent;
	width: 32px;
	height: 32px;
	padding: 6px;
	margin: 1px;
	overflow: hidden;
	background-repeat: no-repeat;
	background-size: 100%;
	background-origin: content-box;
}
#comments-list-mode-selector button:disabled {
	cursor: auto;
}
#comments-list-mode-selector button.expanded {
	background-image: url('data:image/gif;base64,<?php echo base64_encode(file_get_contents("assets/expanded.gif")) ?>');
}
#comments-list-mode-selector button.compact {
	background-image: url('data:image/gif;base64,<?php echo base64_encode(file_get_contents("assets/compact.gif")) ?>');
}

#content.compact > .comment-thread {
	font-size: 0.9375rem;
}
#content.compact > .comment-thread .comment-body {
	font-size: 1.0625rem;
}
#content.compact > .comment-thread .comment-item {
	max-height: 71px;
	margin-top: 1em;
	overflow: hidden;
	position: relative;
	pointer-events: none;
}
#content.compact > .comment-thread .comment-item::after {
	content: "…";
	position: absolute;
	right: 0;
	bottom: 0;
	font-size: 2rem;
	line-height: 1;
	padding: 0 16px 10px 64px;
	pointer-events: auto;
}
#content.compact > #top-nav-bar + .comment-thread .comment-item {
	margin-top: 2.25em;
}
#content.compact > .comment-thread .comment-item:hover {
	overflow: visible;
	pointer-events: auto;
	z-index: 10;
}
#content.compact > .comment-thread .comment-item .comment-meta {
	white-space: nowrap;
	overflow: hidden;
	text-overflow: ellipsis;
	padding: 2px 10px;
}
#content.compact > .comment-thread .comment-item:hover .comment-meta {
	white-space: unset;
}
#content.compact > .comment-thread .comment-item .comment-meta a {
	pointer-events: auto;
}
#content.compact > .comment-thread .comment-item .comment-meta .comment-post-title {
	display: inline;
}
#content.compact > .comment-thread .comment-item .comment-meta .karma + .comment-post-title {
	margin-left: 0.75em;
}
#content.compact > .comment-thread:last-of-type .comment-item:hover {
	max-height: unset;
}
#content.compact > .comment-thread .comment-item:hover .comment {
	position: relative;
	z-index: 1;
	margin-bottom: 2em;
	bottom: 0;
}
#content.compact > .comment-thread .comment-item:hover .comment::before {
	content: "";
	position: absolute;
	display: block;
	width: calc(100% + 20px);
	height: calc(100% + 20px);
	z-index: -1;
	top: -10px;
	left: -10px;
}
#content.compact > .comment-thread:last-of-type .comment-item:hover .comment {
	margin: 0;
}

/*****************************/
/* HIGHLIGHTING NEW COMMENTS */
/*****************************/

.new-comment::before {
	content: "";
	position: absolute;
	width: 100%;
	height: 100%;
	z-index: 5000;
	pointer-events: none;
}

/***********************************/
/* COMMENT THREAD MINIMIZE BUTTONS */
/***********************************/

.comment-minimize-button {
	font-family: Font Awesome;
	font-weight: 900;
	font-size: 1.25rem;
	line-height: 1;
	position: absolute;
	right: 1px;
	top: 1px;
	width: 18px;
	margin: 0;
	cursor: pointer;
}
.comment-minimize-button:active {
	transform: scale(0.9);
}
.comment-minimize-button::after {
	content: attr(data-child-count);
	font-weight: normal;
	font-size: 0.8125rem;
	position: absolute;
	left: 0;
	width: 100%;
	text-align: center;
	top: 21px;
}
#content.individual-thread-page .comment-minimize-button {
	display: none;
}

/***********************************/
/* INDIVIDUAL COMMENT THREAD PAGES */
/***********************************/

.individual-thread-page > h1 {
	line-height: 1;
}
.individual-thread-page .comment-controls .edit-button {
	right: 4px;
}
.individual-thread-page #comments {
	border: none;
}

/****************/
/* VOTE BUTTONS */
/****************/

.vote {
	margin: 0;
}
.vote {
	font-family: Font Awesome;
	font-weight: 900;
	border: none;
}
.upvote {
	color: #c8c8c8;	
}
.upvote::before {
	content: '\F055';
}
.downvote {
	color: #ccc;
}
.downvote::before {
	content: '\F056';
}

/*****************************/
/* COMMENTING AND POSTING UI */
/*****************************/

.comment-controls {
	text-align: right;
	margin: 0 8px 8px 16px;
}
.comment-thread .comment-controls + .comment-thread > li:first-child {
	margin-top: 8px;
}
#comments > .comment-controls {
	margin: 8px 0 0 0;
}
#comments > .comment-controls:last-child {
	margin: 8px 0 16px 0;
}
#comments > .comment-controls > button {
	font-weight: 600;
	font-size: 1.5rem;
	padding: 0;
	margin: 0 0.25em;
}
.posting-controls textarea {
	display: block;
	width: 100%;
	height: 15em;
	min-height: 15em;
	max-height: calc(100vh - 6em);
	margin: 2px 0;
	padding: 4px 5px;
	font-size: 1.2rem;
	border: 1px solid #aaa;
	border-top-width: 29px;
	box-shadow: 
		0 0 0 1px #eee inset;
	resize: none;
}
.posting-controls textarea:focus {
	background-color: #ffd;
	border-color: #00e;
	box-shadow: 
		0 0 0 1px #ddf inset,
		0 0 0 1px #fff,
		0 0 0 2px #00e;
}
.posting-controls form span {
	float: left;
	padding: 5px 0 0 6px;
}
.markdown-reference-link a {
	padding-right: 1.5em;
	margin-right: 0.15em;
	position: relative;
}
.markdown-reference-link a::before {
	content: "";
	position: absolute;
	top: 0;
	width: 100%;
	height: 100%;
	background-image: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAJAAAACQCAQAAABNTyozAAAEDklEQVR4Ae3cY3QDjRaG0V1e27Zt27Zt27Ztf7Zt27Zt10jOdZtZzbSN2q41533+tsFO4zRi0TKRJVACJdDiJVACJVACJVACZQmUQAmUQAmUQAmUQFkCJVACJVACJVACJVDWuD7P8icnGRcVbdyJ/uRZ+jTZYxwq/lN2qMcozvtMibmySe/TsPeqi0JZ3XsAHm1SZAua9CjgoMQo6UB4uiim5gbXV7Ab1EQxT+P3RRw/dHtV3e39UL3g8XuOEw39QNX3g4LHcYwU/n5uo+q7beGKNqLwJ3U1cteKuepEQ1cid03BJIESKIESKIESKIESaIkl0I3dv7Q7a293c//ShrWym7l/abdbGaCnidJGPFzre6opUdqDtLJXitJ+svpA4Uy30dru6hJRHaCws37L37CDRbWAwvctf38S1QOqe43l7f2iikDheg+x9J5ksqpA4TS3svju5CJRXaCwvX7lG3KAqDZQ+Jby/U4kUM0rNN+7hAQSrvNAC/c4Ewn0/052C8Xd0fkigebbRp/5DdpHJFCxr5nfr4QEUqzmJYC3iQRq1jXuj8cYT6CyTnAv54oEKm9EJFBnJVAC7eoS0XJn2r8qQP/wNFOipUY8wvbVAeIjooXq3ki1gPhHC0A/oWWgQZ/37ZI2FaUdVPpb33LHlQS6scPFstrDQBtAvEpNdLEfsZJA3N3lYsnOcTvaAuKzomttqW+lgXimabFoYx5N20D8SXSlw9yElQfiE0J5dW+lI6BBu4uOO8+dWB0g1hel/YIOgbiVE0VHXefhrB7QTRwtmra3gS4AcW+Xibab8SJWE4h7uaLpn/Ud6AoQTzIu2uzDrDYQzzUjCo17HF0D4g3qoo1+yWoCld8hv5OuAvFl0XLb6V8rQGws5votXQfqs45oqaPdjLUDdNO5f7Xa32APgBhu6b2SC92VtQTEfVwlXOhO9ASI2zhNLKsRj2atAfFCo55Iz4C4nyvFks16OWsRiPvQUyCeblIs0adYq0B6DsTb1EV5fk+1gfiWKG0XAwnUZyPRtOPdggTiRg4UC7rEPUkg4PbOFIXGPIEEmt+DCmeu5rUkUHHPaXj76Qsk0MK9R/ynv5FAzfdDYS9Da+n/xe6ovd2lS/8vVlyfH7o1vQLKJVACJVACJVACJVACIYGW/A6z/A6zG8RcNbdT9d1eTcx1A8eKhn6s6vtxweNYfisaqvupu+jXV8H63cXP1Asev+Wpopi6aVMVbFpdFPMUlP6jdrY/8AgTYkHZhEcAvFNdFMpq3qFh78y/okIT3qk4j8zborn290hN91S/c6zrzapVsFnXO9bvPFXjYtEykSVQAnVUAiVQAiVQAiVQAiVQlkAJlEAJlEAJlEAJlCVQAiVQAiVQAiVQAmX/BMHb3CdNrgcrAAAAAElFTkSuQmCC');
	background-size: 1.25em;
	background-repeat: no-repeat;
	background-position: right center;
}
#markdown-hints-checkbox + label {
	float: left;
	padding: 4px 0 0 0;
	margin: 0 0 0 1em;
	color: #00e;
	cursor: pointer;
}
#edit-post-form #markdown-hints-checkbox + label {
	padding: 2px 0 0 0;
}
#markdown-hints-checkbox {
	visibility: hidden;
}
#markdown-hints-checkbox + label::after {
	content: "(Show Markdown help)";
}
#markdown-hints-checkbox:checked + label::after {
	content: "(Hide Markdown help)";
}
#markdown-hints-checkbox + label::before {
	content: '\F059';
	font-family: Font Awesome;
	font-weight: 900;
	margin-right: 3px;
}
#markdown-hints-checkbox:checked + label::before {
	font-weight: normal;
}
#markdown-hints-checkbox + label:hover {
	color: #e00;
	text-shadow:
		0 0 1px #fff,
		0 0 3px #fff;
}
.markdown-hints {
	margin: 4px 0 0 4px;
	padding: 4px 8px;
	border: 1px solid #c00;
	background-color: #ffa;
	position: absolute;
	text-align: left;
	top: calc(100% - 1em);
	z-index: 1;
	display: none;
}
#markdown-hints-checkbox:checked ~ .markdown-hints {
	display: table;
}
.markdown-hints-row {
	display: table-row;
}
.markdown-hints .markdown-hints-row span,
.markdown-hints .markdown-hints-row code {
	float: none;
	display: table-cell;
	border: none;
	background-color: inherit;
	padding: 0 12px 0 0;
}
.posting-controls input[type='submit'] {
	margin: 6px;
	background-color: #fff;
	padding: 4px 10px;
	border: 1px solid #aaa;
	font-weight: bold;
	font-size: 1.125rem;
}
.posting-controls input[type='submit']:hover,
.posting-controls input[type='submit']:focus {
	background-color: #ddd;
	border: 1px solid #999;
}
.posting-controls button {
	border: none;
	font-weight: 600;
	padding: 1px 6px;
	position: relative;
	z-index: 1;
}
.comment-controls .cancel-comment-button,
#comments > .comment-controls .cancel-comment-button {
	position: absolute;
	right: 8px;
	margin: 0;
	height: 27px;
	font-size: inherit;
	color: #c00;
	text-shadow: 
		0 0 1px #fff,
		0 0 2px #fff;
	padding: 4px 8px 2px 4px;
}
#comments > .comment-controls .cancel-comment-button {
	right: 30px;
}
.comment-controls .cancel-comment-button:hover,
#comments > .comment-controls .cancel-comment-button:hover {
	color: #f00;
	text-shadow:
		0 0 1px #fff,
		0 0 3px #fff,
		0 0 5px #fff;
}
.comment + .comment-controls .action-button {
	font-weight: normal;
	font-size: 1.0625em;
}
.comment-controls .edit-button {
	position: absolute;
	right: 24px;
	top: 7px;
	color: #0b0;
}
.comment-thread .comment-thread .edit-button {
	right: 8px;
}
.comment-controls .edit-button:hover {
	color: #f00;
}
.comment-controls .action-button::before {
	font-family: Font Awesome;
	margin-right: 3px;
}
.comment-controls .reply-button::before {
	content: '\F3E5';
	font-weight: 900;
	font-size: 0.9em;
	opacity: 0.6;
}
.post-controls {
	text-align: right;
}
.edit-post-link {
	display: inline-block;
	margin-bottom: 0.25em;
	font-size: 1.125rem;
}
.edit-post-link,
.edit-post-link:visited {
	color: #090;
}
.edit-post-link::before {
	margin-right: 0.3em;
}
.comment-controls .edit-button::before,
.edit-post-link::before {
	content: '\F303';
	font-family: "Font Awesome";
	font-weight: 900;
	font-size: 0.75em;
	position: relative;
	top: -1px;
}
.comment-controls .cancel-comment-button::before {
	font-family: Font Awesome;
	margin-right: 3px;
	content: '\F00D';
	font-weight: 900;
	font-size: 0.9em;
	opacity: 0.7;
}
.comment-controls form {
	position: relative;
}
.guiedit-buttons-container {
	background-image: linear-gradient(to bottom, #fff 0%, #ddf 50%, #ccf 75%, #aaf 100%);
	position: absolute;
	left: 1px;
	top: 1px;
	width: calc(100% - 2px);
	height: 28px;
	text-align: left;
	padding: 1px 4px 0 4px;
	overflow: hidden;
}
.post-page .guiedit-buttons-container {
	padding-right: 60px;
}
.guiedit-buttons-container button {
	height: 26px;
	padding: 0 7px;
	font-weight: 900;
	font-size: 0.875rem;
	line-height: 1;
	position: static;
}
.guiedit-buttons-container button:active {
	transform: none;
}
.guiedit-buttons-container button:active div {
	transform: scale(0.9);
}
.guiedit-buttons-container button sup {
	font-weight: bold;
}
.guiedit::after {
	content: attr(data-tooltip);
	position: absolute;
	font-weight: normal;
	font-family: <?php echo $UI_font; ?>;
	font-size: 1rem;
	top: 2px;
	left: 440px;
	color: #777;
	text-shadow: none;
	height: 25px;
	padding: 4px 0;
	white-space: nowrap;
	visibility: hidden;
}
.guiedit:hover::after {
	visibility: visible;
}
.textarea-container {
	position: relative;
}


/******************/
/* EDIT POST FORM */
/******************/

#edit-post-form {
	padding: 1em 1em 3em;
}
#edit-post-form {
	padding-bottom: 4em;
}
#edit-post-form .post-meta-fields {
	overflow: auto;
}

#edit-post-form input[type='text'] {
	width: calc(100% - 6em);
	margin: 0.25em 0;
}
#edit-post-form input {
	width: auto;
}
#edit-post-form input[type='submit'] {
	padding: 6px 12px;
	float: right;
}
#edit-post-form .link-post-checkbox {
	height: 0;
	opacity: 0;
	pointer-events: none;
}
#edit-post-form .link-post-checkbox + label {
	padding-left: 6px;
	margin-left: 0.5em;
	white-space: nowrap;
	position: relative;
	cursor: pointer;
}
#edit-post-form .link-post-checkbox + label::before {
	content: "";
	font-family: Font Awesome;
	font-size: 1.375rem;
	color: #777;
	line-height: 0.7;
	text-indent: 1px;
	font-weight: 900;
	position: absolute;
	width: 20px;
	height: 20px;
	border-radius: 3px;
	border: 1px solid #ddd;
	left: -20px;
	top: 4px;
}
#edit-post-form .link-post-checkbox + label:hover,
#edit-post-form .link-post-checkbox:focus + label {
	text-shadow: 
		0 0 1px #fff,
		0 0 2px #fff,
		0 0 2.5px #aaa;
}
#edit-post-form .link-post-checkbox + label:hover::before,
#edit-post-form .link-post-checkbox:focus + label::before {
	border-color: #aaa;
}
#edit-post-form .link-post-checkbox:checked + label::before {
	content: "\F00C";
}
#edit-post-form label[for='url'],
#edit-post-form input[name='url'] {
	display: none;
}
#edit-post-form .link-post-checkbox:checked ~ label[for='url'],
#edit-post-form .link-post-checkbox:checked ~ input[name='url'] {
	display: block;
}
#edit-post-form label {
	clear: none;
	margin: 0.25em 0;
	line-height: normal;
	border: 1px solid transparent;
}
#edit-post-form label[for='url'] {
	clear: left;
}
#edit-post-form label[for='title'],
#edit-post-form label[for='url'],
#edit-post-form label[for='section'] {
	width: 6em;
}
#edit-post-form input[name='title'] {
	max-width: calc(100% - 12.5em);
}
#edit-post-form label[for='link-post'] {
	width: 4em;
}
#edit-post-form label[for='section'] {
	margin: 0.35em 0;
}
#edit-post-form input[type='radio'] {
	width: 0;
	margin: -5px;
	opacity: 0;
	pointer-events: none;
}
#edit-post-form input[type='radio'] + label {
	margin: 0.35em 0;
	width: auto;
	color: #777;
	padding: 0.25em 0.75em;
	text-align: center;
	border-color: #ddd;
	border-style: solid;
	border-width: 1px 1px 1px 0;
	cursor: pointer;
}
#edit-post-form input[type='radio'][value='all'] + label {
	border-radius: 8px 0 0 8px;
	border-width: 1px;
}
#edit-post-form input[type='radio'][value='drafts'] + label {
	border-radius: 0 8px 8px 0;
}
#edit-post-form input[type='radio'] + label:hover,
#edit-post-form input[type='radio']:focus + label {
	background-color: #ddd;
	color: #000;
}
#edit-post-form input[type='radio']:focus + label {
	color: #000;
	position: relative;
	box-shadow: 
		0 0 0 1px #aaa;
}
#edit-post-form input[type='radio']:checked + label {
	background-color: #ddd;
	border-color: #ddd;
	color: #000;
	text-shadow: 
		0 -1px 0 #fff,
		0 0.5px 0.5px #000;
	cursor: default;
}
#edit-post-form textarea {
	min-height: 24em;
	margin-top: 4px;
}
#edit-post-form .guiedit-buttons-container {
	top: -3px;
}
#edit-post-form .markdown-hints {
	top: calc(100% + 2em);
}
#edit-post-form select {
	border: 1px solid #ddd;
	background-color: inherit;
	font-family: inherit;
	font-size: inherit;
	font-weight: 600;
	vertical-align: top;
	height: 33px;
	padding: 4px;
}
#content.edit-post-page {
	overflow: visible;
}

.guiedit-mobile-auxiliary-button {
	display: none;
}

/*********/
/* LINKS */
/*********/

a {
	text-decoration: none;
	color: #00e;
}
a:visited {
	color: #551a8b;
}
a:hover {
	text-decoration: underline;
}

/***********/
/* BUTTONS */
/***********/

button,
input[type='submit'] {
	font-family: inherit;
	font-size: inherit;
	color: #00e;
	background-color: inherit;
	cursor: pointer;
	border: none;
	border-radius: 0;
}
button:hover,
input[type='submit']:hover {
	color: #d00;
	text-shadow:
		0 0 1px #fff,
		0 0 3px #fff,
		0 0 5px #fff;
}
button:active,
input[type='submit']:active {
	color: #f00;
	transform: scale(0.9);
}
.button:hover {
	color: #d00;
	text-shadow:
		0 0 1px #fff,
		0 0 2px #fff,
		0 0 4px #fff,
		0 0 2px #f00;
	text-decoration: none;
}
.button:active {
	transform: scale(0.9);
}
.button:focus:not(:hover) {
	transform: none;
}
@-moz-document url-prefix() {
	.button:active {
		transform: none;
	}
}

/************/
/* HEADINGS */
/************/

h1 {
	font-weight: <?php echo ($platform == 'Mac') ? "700" : "800"; ?>;
}

.post-body h1,
.post-body h2,
.post-body h3,
.post-body h4,
.post-body h5,
.post-body h6,
.comment-body h1,
.comment-body h2,
.comment-body h3,
.comment-body h4,
.comment-body h5,
.comment-body h6 {
	font-family: <?php echo $UI_font; ?>;
	line-height: 1.1;
	margin: 1em 0 0.75em 0;
	text-align: left;
}

.post-body h5,
.post-body h6,
.comment-body h5,
.comment-body h6 {
	font-size: 1em;
	font-weight: 600;
	font-family: <?php echo ($platform == 'Windows') ? "'Whitney SmallCaps'" : "'Concourse SmallCaps'"; ?>;
}
.post-body h6,
.comment-body h6 {
	color: #555;
}
.post-body h4,
.comment-body h4 {
	font-size: 1.2em;
}
.post-body h3,
.comment-body h3 {
	font-size: 1.4em;
	font-family: <?php echo ($platform == 'Windows') ? "'Whitney SmallCaps'" : "'Concourse SmallCaps'"; ?>;
	font-weight: 600;
}
.post-body h2,
.comment-body h2 {
	font-size: 1.75em;
}
.post-body h1,
.comment-body h1 {
	font-size: 2.1em;
	border-bottom: 1px solid #aaa;
}

/********/
/* MISC */
/********/

blockquote {
	font-size: 0.9em;
	margin: 1em 0;
	padding-left: 0.5em;
	border-left: 5px solid #ccc;
	margin-left: 1px;
	padding-bottom: 3px;
}
blockquote *:first-child {
	margin-top: 0;
}
blockquote *:last-child {
	margin-bottom: 0;
}
blockquote blockquote {
	font-size: 0.95em;
}

.post-body img,
.comment-body img {
	max-width: 100%;
	border: 1px solid #ccc;
}
.post-body img[src$='.svg'],
.comment-body img[src$='.svg'] {
	border: none;
}

img.inline-latex {
	position: relative;
	top: 2.5px;
	margin: 0 2px;
}

#content figure {
	text-align: center;
	margin: 1.5em auto;
}
#content figure img {
	border: 1px solid #000;
}
#content figure img[src$='.svg'] {
	border: none;
}

p.imgonly,
div.imgonly {
	text-align: center;
}

li {
	margin-bottom: 0.5em;
}

sup, sub {
	vertical-align: baseline;
	position: relative;
	top: -0.5em;
	left: 0.05em;
	font-size: 0.8em;
}
sub {
	top: 0.3em;
	-webkit-hyphens: none;
	-ms-hyphens: none;
	hyphens: none;
}

hr {
	border: none;
	border-bottom: 1px solid #999;
}

pre {
	white-space: pre-wrap;
}
code {
	font-family: Inconsolata, Menlo, monospace;
	font-size: 0.95em;
	display: inline-block;
	background-color: #f6f6ff;
	border: 1px solid #ddf;
	padding: 0 4px 1px 5px;
	border-radius: 4px;
}
pre > code {
	display: block;
	border-radius: 0;
	padding: 3px 4px 5px 8px;
}

input[type='text'],
input[type='search'],
input[type='password'],
textarea {
	-webkit-appearance: none;
	background-color: #fff;
	color: #000;
}

select {
	color: #000;
}

.frac::after {
	content: "\200B";
}

.about-page u {
	background-color: #e6e6e6;
	text-decoration: none;
	box-shadow: 
		0 -1px 0 0 #000 inset, 
		0 -3px 1px -2px #000 inset;
	padding: 0 1px;
}
.mjx-chtml {
	clear: both;
}

/*************/
/* FOOTNOTES */
/*************/

ol {
	counter-reset: ordered-list;
}
.footnote-definition {
	font-size: 0.9em;
	list-style-type: none;
	counter-increment: ordered-list;
	position: relative;
}
.footnote-definition p {
	font-size: inherit !important;
}
.footnote-definition::before {
	content: counter(ordered-list) ".";
	position: absolute;
	left: -2.5em;
	font-weight: bold;
	text-align: right;
	width: 2em;
}

/*********/
/* LISTS */
/*********/

.post-body ol p,
.post-body ul p,
.comment-body ol p,
.comment-body ul p {
	margin: 0.5em 0;
}

.post-body ol {
	list-style: none;
	padding: 0;
	counter-reset: ol;
}
.post-body ol > li {
	position: relative;
	counter-increment: ol;
	padding: 0 0 0 2.5em;
	margin: 0.25em 0 0 0;
}
.post-body ol > li::before {
	content: counter(ol) ".";
	position: absolute;
	width: 2em;
	text-align: right;
	left: 0;
}
.post-body ul {
	list-style: none;
	padding: 0;
}
.post-body ul:not(.contents-list) li {
	position: relative;
	padding: 0 0 0 2.5em;
	margin: 0.25em 0 0 0;
}
.post-body ul:not(.contents-list) li::before {
	content: "•";
	position: absolute;
	width: 2em;
	text-align: right;
	left: 0;
}
.post-body li > ul:first-child > li {
	padding-left: 0;
}
.post-body li > ul:first-child > li::before {
	content: none;
}

/**************/
/* ABOUT PAGE */
/**************/

#content.about-page .contents {
	margin-top: 0.25em;
}
#content.about-page .accesskey-table {
	font-family: <?php echo $UI_font; ?>;
	border-collapse: collapse;
	border-color: #ddd;
	margin: auto;
}
#content.about-page .accesskey-table th,
#content.about-page .accesskey-table td {
	padding: 2px 6px;
}
#content.about-page .accesskey-table td:first-child {
	padding-right: 1.5em;
}
#content.about-page .accesskey-table td:last-child {
	text-align: center;
	font-family: Inconsolata, Menlo, monospace;
}
#content.about-page img {
	border: 1px solid #000;
}
#content.about-page h3:nth-of-type(n+2) {
	clear: both;
}

/*******************/
/* USER STATS PAGE */
/*******************/

.user-stats .karma-total {
	font-weight: bold;
}

/******************/
/* IMAGES OVERLAY */
/******************/

#images-overlay {
	position: absolute;
	z-index: 1;
	width: 100%;
	padding-left: calc((100% - 900px) / 2 + 60px);
	padding-right: calc((100% - 900px) / 2 + 60px);
}
#images-overlay img {
	position: absolute;
	left: 0;
	right: 0;
	margin: auto;
}
#images-overlay + #content .post-body img {
	visibility: hidden;
}

/**************************/
/* QUALIFIED HYPERLINKING */
/**************************/

#content.no-comments #comments, 
#content.no-comments .post-meta .comment-count,
#content.no-comments .post-meta .karma,
#content.no-comments + #ui-elements-container #new-comment-nav-ui,
#content.no-comments + #ui-elements-container #hns-date-picker,
#content.no-comments + #ui-elements-container #quick-nav-ui {
	display: none;
}

#content.no-nav-bars #primary-bar,
#content.no-nav-bars #secondary-bar {
	display: none;
}
#content.no-nav-bars {
	margin: 8px auto;
}
#content.no-nav-bars + #ui-elements-container > * {
	padding-top: 8px;
}

#aux-about-link {
	position: fixed;
	top: 40px;
	left: calc((100% - 900px) / 2 - 69px);
	width: 1.5em;
	height: 1.5em;
	text-align: center;
	display: table;
}
#aux-about-link a {
	display: table-cell;
	width: 100%;
	vertical-align: middle;
	font-family: Font Awesome;
	font-weight: 900;
	font-size: 1.25rem;
	color: #777;
	opacity: 0.4;
	z-index: 1;
}
#aux-about-link a:hover {
	opacity: 1.0;
	text-shadow: 
		0 0 1px #fff, 
		0 0 3px #fff, 
		0 0 5px #fff;
}

.qualified-linking {
	margin: 0;
	position: relative;
}
.qualified-linking input[type='checkbox'] {
	visibility: hidden;
	width: 0;
	height: 0;
}
.qualified-linking label {
	color: #00e;
	font-family: Font Awesome;
	font-weight: 900;
	font-size: 1rem;
	padding: 0 0.5em;
	display: inline-block;
	margin-left: 0.25em;
}
.qualified-linking label:hover {
	text-shadow:
		0 0 1px #fff,
		0 0 3px #fff,
		0 0 5px #00e;
	cursor: pointer;
}
.qualified-linking label:active span {
	display: inline-block;
	transform: scale(0.9);
}
.qualified-linking label::selection {
	background-color: transparent;
}

.qualified-linking label::after {
	content: "";
	width: 100vw;
	height: 0;
	left: 0;
	top: 0;
	position: fixed;
	z-index: 1;
	cursor: default;
}
.qualified-linking input[type='checkbox']:checked + label::after {
	height: 100vh;
}

.qualified-linking-toolbar {
	border: 1px solid #000;
	position: absolute;
	right: 0.25em;
	top: 110%;
	background-color: #fff;
	z-index: 1;
}
.qualified-linking input[type='checkbox'] ~ .qualified-linking-toolbar {
	display: none;
}
.qualified-linking input[type='checkbox']:checked ~ .qualified-linking-toolbar {
	display: block;
}
#qualified-linking-toolbar-toggle-checkbox-bottom ~ .qualified-linking-toolbar {
	top: unset;
	bottom: 125%;
}

.qualified-linking-toolbar a {
	display: block;
	background-color: #eee;
	padding: 0 6px;
	margin: 4px;
	border: 1px solid #ccc;
	border-radius: 4px;
}
.qualified-linking-toolbar a:visited {
	color: #00e;
}
.qualified-linking-toolbar a:hover {
	text-decoration: none;
	background-color: #ddd;
	text-shadow:
		0 0 1px #fff,
		0 0 3px #fff,
		0 0 5px #fff;
}
.qualified-linking-toolbar a::selection {
	background-color: transparent;
}

/********/
/* MATH */
/********/

div > .MJXc-display {
	max-width: 100%;
	overflow-y: hidden;
	padding: 10px 6px;
	border-radius: 6px;
}
.MJXc-display::-webkit-scrollbar {
	height: 12px;
	background-color: #f6f6ff;
	border-radius: 6px;
	border: 1px solid #ddf;
}
.MJXc-display::-webkit-scrollbar-thumb {
	background-color: #dde;
	border-radius: 6px;
	border: 1px solid #cce;
}

/**********************/
/* FOR NARROW SCREENS */
/**********************/

@media only screen and (max-width: 1020px) {
	#new-comment-nav-ui {
		right: calc((100vw - 900px) / 2 - 61px);
		z-index: 5001;
	}
	#new-comment-nav-ui .new-comments-count::before {
		content: "";
		background-color: #efe;
		position: absolute;
		width: 100%;
		height: calc(100% + 45px);
		z-index: -1;
		left: 0;
		top: -22px;
		box-shadow: 0 0 2px #eee;
		border-radius: 8px;
	}
	#quick-nav-ui {
		right: calc((100vw - 900px) / 2 - 51px);
	}
	#width-selector {
		display: none;
	}
}
@media only screen and (max-width: 900px) {
	#content {
		padding: 0 4px;
	}
	#content.post-page {
		padding-bottom: 112px;
	}
	#content > a:last-child,
	#content > a:first-child {
		margin: 0 -4px;
	}
	.nav-bar {
		width: calc(100% + 8px);
	}
	.nav-bar .nav-inner {
		padding: 8px 3.33vw;
	}
	#secondary-bar .nav-inner {
		padding: 2px 0 3px 0;
	}
	.nav-bar {
		margin: 0 -4px;
	}
	.login-container, .login-container > div {
		display: block;
	}
	.contents {
		float: none;
		display: table;
		max-width: none;
		margin-left: auto;
		margin-right: auto;
	}
	.post-body,
	.post > h1:first-child {
		padding: 0 6px;
	}
	.post-body, .comment-body {
		text-align: left;
		-webkit-hyphens: none;
		-ms-hyphens: none;
		hyphens: none;
	}
	@-moz-document url-prefix() {
		.post-body, .comment-body {
			text-align: justify;
			-webkit-hyphens: auto;
			-ms-hyphens: auto;
			hyphens: auto;
		}
	}
	.nav-inner::after {
		display: none;
	}
	#new-comment-nav-ui {
		right: 12px;
		bottom: 12px;
	}
	#new-comment-nav-ui .new-comments-count {
		z-index: 2;
	}
}
@media only screen and (max-width: 768px) {
	#login-form-container,
	#create-account-form-container {
		width: unset;
		float: unset;
	}
	.sublevel-nav.sort {
		position: unset;
		margin-top: 1.75em;
		margin-bottom: -1.25em;
	}
}
@media only screen and (max-width: 520px) {
	.nav-inner,
	#secondary-bar .nav-inner {
		font-size: 0.85em;
	}
	#bottom-bar .nav-inner {
		font-size: 1em;
	}
	h1.listing {
		font-size: 1.3rem;
		line-height: 1.1;
		margin: 0.5em 6px 0 6px;
	}
	h1.listing a {
		display: inline-block;
		padding: 0.4em 0 0.1em 0;
		text-indent: 33px;
	}
	h1.listing a[href^='/'] {
		text-indent: 0;
	}
	h1.listing a[href^="http"] {
		top: 10px;
	}
	h1.listing + .post-meta {
		margin: 0 6px 0 7px;
	}
	#secondary-bar #nav-item-search form {
		padding: 3px 4px 4px 4px;
	}
	.post-body {
		font-size: 1.2rem;
		line-height: 1.45;
		text-align: center;
	}
	.post-body > * {
		text-align: left;
	}
	.post > h1:first-child {
		margin: 1em 0.25em 0.25em 0.25em;
		font-size: 2em;
	}
	.comment-item .comment-item {
		margin: 0.75em 4px 4px 4px;
		box-shadow: 
			0 0 2px #ccc, 
			0 0 4px #ccc, 
			0 0 7px #ccc;
	}
	.comment-item .comment-item + .comment-item {
		margin: 1.5em 4px 4px 4px;
	}
	.comment-body ul {
		padding-left: 30px;
	}
	.contents {
		max-width: 100%;
		margin: 1em 0 0 0;
		display: inline-block;
	}
	.contents-head {
		font-size: 1.2em;
	}
	div[class^='archive-nav-'] {
		display: block;
		text-align: justify;
	}
	.archive-nav *[class^='archive-nav-item'],
	.archive-nav *[class^='archive-nav-item']:first-child {
		display: inline-block;
		width: auto;
		padding: 6px 10px;
		width: 4em;
		margin: 2px;
	}
	.archive-nav *[class^='archive-nav-item'],
	.archive-nav *[class^='archive-nav-item-'],
	.archive-nav div[class^='archive-nav-']:nth-of-type(n+2) *[class^='archive-nav-item'] {
		border: 1px solid #ddd;
	}
	.archive-nav > *[class^='archive-nav-'] +	*[class^='archive-nav-'] {
		margin-top: 0.5em;
	}
	#nav-item-recent-comments > * > span {
		display: none;
	}
	#primary-bar,
	#secondary-bar {
		table-layout: fixed;
		font-size: 0.55em;
	}
	#secondary-bar {
		font-size: 0.5em;
	}
	#primary-bar .nav-inner,
	#secondary-bar .nav-inner {
		text-transform: uppercase;
		padding: 6px;
		font-weight: 600;
	}
	#secondary-bar .nav-inner {
		padding: 4px;
	}
	#primary-bar .nav-inner::before, 
	#secondary-bar .nav-inner::before {
		display: block;
		font-family: "Font Awesome";
		font-size: 1.25rem;
		font-weight: 900;
	}
	#secondary-bar .nav-inner::before {
		font-size: 0.875rem;
	}
	#nav-item-home .nav-inner::before {
		content: "\F015";
	}
	#nav-item-featured .nav-inner::before {
		content: "\F005";
	}
	#nav-item-all .nav-inner::before {
		content: "\F069";
	}
	#nav-item-meta .nav-inner::before {
		content: "\F077";
	}
	#nav-item-recent-comments .nav-inner::before {
		content: "\F036";
	}
	#nav-item-archive {
		width: auto;
	}
	#nav-item-archive .nav-inner::before {
		content: "\F187";
	}
	#nav-item-about {
		width: auto;
	}
	#nav-item-about .nav-inner::before {
		content: "\F129";
	}
	#nav-item-search {
		font-size: 2em;
		vertical-align: middle;
	}
	#nav-item-search .nav-inner::before {
		content: none;
	}
	#nav-item-search input {
		width: calc(100% - 28px);
	}
	#nav-item-search button {
		width: 22px;
		color: transparent;
		vertical-align: bottom;
		padding-left: 4px;
		overflow: visible;
	}
	#nav-item-search button::before {
		content: "\F002";
		color: #00e;
		font-family: Font Awesome;
		font-weight: 900;
		font-size: 1rem;
	}
	#nav-item-login {
		width: auto;
	}
	#nav-item-login .nav-inner::before {
		content: "\F007";
	}
	.post-meta {
		line-height: 1.9;
	}
	.post-meta > *,
	.post-meta .lw2-link {
		margin: 0 0.5em;
	}
	.post-meta .lw2-link {
		opacity: 0.5;
	}
	a.comment-parent-link {
		position: relative;
		width: 0;
		visibility: hidden;
	}
	a.comment-parent-link::before {
		display: inline-block;
		width: unset;
		height: unset;
		padding: 0;
		font-size: 1em;
		left: 0;
		top: 0;
		line-height: inherit;
		visibility: visible;
		color: #000;
		content: "\F3BF";
		transform: scaleX(-1);
	}
	a.comment-parent-link::after {
		display: none;
	}
	.page-toolbar {
		font-size: 1rem;
		margin: 0.25em;
	}
	#top-nav-bar {
		margin-top: 1.5em;
	}
	.sublevel-nav {
		display: table;
		margin: auto;
		padding: 0 1em;
	}
	.sublevel-nav .sublevel-item {
		display: table-cell;
		font-size: 1rem;
		padding: 0.25em 0.5em;
	}
	.comment-minimize-button::after {
		height: 100%;
		top: 0;
		left: -2em;
		width: 1.5em;
		line-height: 1.6;
		text-align: right;
	}
	#edit-post-form label[for='title'] {
		width: 2.5em;
	}
	#edit-post-form label[for='url'] {
		width: 2.5em;
	}
	#edit-post-form label[for='section'] {
		width: 3.6em;
	}
	#edit-post-form label[for='url'], 
	#edit-post-form label[for='section'],
	#edit-post-form label[for='title'] {
		clear: left;
		text-align: left;
		padding-left: 0;
	}
	#edit-post-form input[name='title'],
	#edit-post-form input[name='url'] {
		max-width: calc(100% - 6.5em);
	}
	#edit-post-form label[for='link-post'] {
		white-space: normal;
		line-height: 0.9;
		width: 2em;
		height: 1em;
	}
	#edit-post-form textarea {
		min-height: unset;
	}
	#edit-post-form .textarea-container:focus-within textarea {
		position: fixed;
		top: -1px;
		left: 2px;
		width: calc(100vw - 4px);
		height: calc(100% - 101px) !important;
		max-height: unset;
		border-width: 1px;
		z-index: 11001;
	}
	#edit-post-form .textarea-container:focus-within .guiedit-buttons-container {
		position: fixed;
		z-index: 11002;
		left: 0;
		width: 100vw;
		height: auto;
		background-image: none;
		background-color: white;
		border-top: 1px solid #ddf;
		padding: 3px 4px 4px 4px;
		margin: 0;
		text-align: center;
	}
	#edit-post-form .textarea-container:focus-within .guiedit-buttons-container {
		top: auto;
		bottom: 0;
	}
	#edit-post-form .textarea-container:focus-within button.guiedit {
		font-size: 0.9375rem;
		line-height: 1.5;
		height: auto;
		width: calc((100% / 10) - 2px);
		padding: 10px 1px 8px 0;
		position: relative;
		background-color: #eee;
		border: 1px solid #ddd;
		border-radius: 6px;
		margin: 1px;
	}
	#edit-post-form .textarea-container:focus-within button.guiedit sup {
		position: absolute;
		left: calc(50% + 0.65em);
		top: calc(50% - 1.3em);
	}
	.textarea-container button:active {
		background-color: #ccc;
	}
	.textarea-container .guiedit-mobile-auxiliary-button {
		z-index: 11011;
		position: fixed;
		bottom: 7px;
		width: calc(((100% - 16px) / 10) * 3 - 7px);
		font-size: 1.25rem;
		padding: 5px;
		background-color: #eee;
		border: 1px solid #ddd;
		border-radius: 6px;
	}
	.textarea-container:focus-within .guiedit-mobile-auxiliary-button {
		display: block;
	}
	.textarea-container .guiedit-mobile-help-button {
		left: 8px;
	}
	.textarea-container .guiedit-mobile-exit-button {
		right: 8px;
	}
	.guiedit::after {
		display: none;
	}
	#edit-post-form input[type='submit'] {
		margin-top: -6px;
	}
	.comment-meta {
		padding: 2px 10px;
	}
	.comment-post-title2 {
		display: block;
		text-overflow: ellipsis;
		overflow: hidden;
	}
	.comment-meta author {
		display: block;
	}
	.comment-meta .karma-value {
		font-weight: 600;
	}
	.comment-meta .karma-value span {
		display: none;
	}
	.comment-meta .lw2-link {
		display: none;
	}
	.comment-body {
		font-size: 1.125rem;
	}
	.comment-body ol {
		padding-left: 30px;
	}
	.contents {
		padding: 0.35em 0.75em 0.4em 0.35em;
	}
	.post-body .contents ul {
		font-size: unset;
	}
	.login-container {
		margin: 0;
	}
	#login-form-container h1 {
		padding: 0;
		margin: 0.5em 0 0.25em 0;
	}
	.login-container form label,
	.login-container form input {
		float: none;
		display: block;
	}
	#login-form label,
	#signup-form label {
		padding: 0.5em 0 0 1px;
		color: #666;
	}
	.login-container form label,
	.login-container form input[type='text'],
	.login-container form input[type='password'] {
		width: calc(100% - 2em);
		margin: 0 1em;
		text-align: left;
			font-size: 1.125rem;
	}
	.login-container form input[type='text'],
	.login-container form input[type='password'] {
			font-weight: 600;
	}
	.login-container form input[type='text'],
	.login-container form input[type='password'] {
	}
	.login-container form input[type='submit'] {
			width: auto;
		margin: 0.75em auto;
		padding: 8px 12px;
		font-size: 1.125rem;
		float: none;
	}
	#create-account-form-container {
		margin: 1em 0 0 0;
		padding: 0;
	}
	#inbox-indicator {
		width: 100%;
	}
	#inbox-indicator::before {
		width: 100%;
		height: 100%;
		font-size: 0.75rem;
		text-align: right;
		padding: 1px 5px;
	}
	a#inbox-indicator.new-messages::before {
		box-shadow: 0 0 5px 1px inset;
	}
}
@media only screen and (max-width: 374px) {
	.nav-bar .nav-inner {
		padding: 6px 3.33vw;
	}
	.sublevel-nav {
		padding: 0 0.5em;
	}
	.sublevel-nav .sublevel-item {
		font-size: 0.9375rem;
	}
	#inbox-indicator::before {
		font-size: 0.625rem;
		text-align: right;
		padding: 1px 5px;
	}
}

<?php if (isset($argv[2]) && preg_match("/\\.css(.php)?$/", $argv[2])) include($argv[2]); ?>
