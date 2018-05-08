/*****************/
/* DEFAULT THEME */
/*****************/

body {
	background-color: #d8d8d8;
}

#content {
	box-shadow: 0px 0px 10px #555;
}

/*=========*/
/* NAV BAR */
/*=========*/

.nav-bar a:link,
.nav-bar a:visited {
	color: #00e;
}

.nav-inner::after {
	display: block;
	position: absolute;
	left: 5px;
	top: -2px;
	font-weight: 400;
	font-size: 0.7em;
	color: #d6d6d6;
}
.nav-inner:hover::after {
	color: #bbb;
}

/*==========*/
/* LISTINGS */
/*==========*/

h1.listing {
	margin: 0.8em 20px 0.1em 20px;
}
h1.listing a {
	color: #000;
}

h1.listing + .post-meta {
	padding-right: 320px;
}
h1.listing + .post-meta > * {
	display: inline;
}
h1.listing + .post-meta .karma-value span,
h1.listing + .post-meta .comment-count span,
h1.listing + .post-meta .lw2-link span,
h1.listing + .post-meta .read-time span {
	display: none;
}
h1.listing + .post-meta .karma-value::before,
h1.listing + .post-meta .comment-count::before,
h1.listing + .post-meta .lw2-link::before,
h1.listing + .post-meta .read-time::before {
	color: #fff;
	font-family: Font Awesome;
	margin: 0 8px 0 0;
	box-shadow: 0 0 0 2px #ddd;
}
h1.listing + .post-meta .karma-value::before {
	content: "\F139";
	font-weight: 900;
	text-shadow: none;
    font-size: 0.9375em;
    line-height: 1.3;
}
h1.listing + .post-meta .comment-count::before {
	content: "\F086";
	font-weight: 900;
}
h1.listing + .post-meta .lw2-link::before {
	content: "\F0C1";
	font-weight: 900;
}
h1.listing + .post-meta .read-time::before {
	content: "\F2F2";
	font-weight: 900;
}
h1.listing + .post-meta .word-count::before {
	content: "\F15C";
	font-weight: 900;
	margin: 0 10px 0 0;
}

h1.listing + .post-meta .karma-value,
h1.listing + .post-meta .comment-count,
h1.listing + .post-meta .lw2-link,
h1.listing + .post-meta .read-time {
	border-radius: 4px;
	padding: 0 4px 0 2px;
	text-shadow: 0.5px 0.5px 0.5px #999;
	margin: 0 0.25em 0 0.5em;
}
h1.listing + .post-meta .karma-value {
	box-shadow: 
		23px 0 0 0 #ddd inset,
		0 0 0 3px #ddd;
	cursor: default;
	color: #c00;
}
h1.listing + .post-meta .comment-count {
	box-shadow: 
		25px 0 0 0 #ddd inset,
		0 0 0 3px #ddd;
	color: #009100;
}
h1.listing + .post-meta .comment-count:hover,
h1.listing + .post-meta .lw2-link:hover {
	text-decoration: none;
	color: #fff;
}
h1.listing + .post-meta .comment-count:hover {
	background-color: #009100;
}
h1.listing + .post-meta .lw2-link:hover {
	background-color: #00f;
}
h1.listing + .post-meta .comment-count:hover::before {
	color: #009100;
}
h1.listing + .post-meta .lw2-link:hover::before {
	color: #00f;
}

h1.listing + .post-meta .lw2-link {
	box-shadow: 
		23px 0 0 0 #ddd inset,
		0 0 0 3px #ddd;
}

h1.listing + .post-meta .read-time {
	box-shadow: 
		21px 0 0 0 #ddd inset,
		0 0 0 3px #ddd;
}
h1.listing + .post-meta .read-time::after {
	content: " min";
}
h1.listing + .post-meta .word-count {
	box-shadow: 
		22px 0 0 0 #ddd inset,
		0 0 0 3px #ddd;
	padding: 0 4px 0 4px;
}
h1.listing + .post-meta .read-time.word-count::after {
	content: none;
}
h1.listing + .post-meta .read-time::before {
	cursor: pointer;
}
h1.listing + .post-meta .read-time:hover::before {
	color: #777;
}

h1.listing + .post-meta .link-post-domain {
	margin: 0 0 0 0.5em;
}

h1.listing + .post-meta::after {
	content: "";
	display: block;
	height: 1px;
	width: calc(100% + 320px);
	background-color: #ddd;
	position: relative;
	top: 14px;
}
h1.listing + .post-meta .karma-value,
h1.listing + .post-meta .comment-count,
h1.listing + .post-meta .lw2-link,
h1.listing + .post-meta .read-time {
	position: absolute;
	line-height: 1.15;
	top: 12px;
}
h1.listing + .post-meta .karma-value {
	right: 31%;
}
h1.listing + .post-meta .comment-count {
	right: 22%;
}
h1.listing + .post-meta .read-time {
	right: 10%;
}
h1.listing + .post-meta .lw2-link {
	right: 0;
}

@media only screen and (max-width: 900px) {
	h1.listing + .post-meta .author {
		margin: 0 0.75em 0 1.5em;
	}
	h1.listing + .post-meta .post-section::before {
		left: 0;
		top: 0;
	}
	h1.listing + .post-meta .post-section {
		display: inline-block;
	}
}
@media only screen and (max-width: 520px) {
	h1.listing + .post-meta {
		padding: 0 0 25px 0;
		white-space: unset;
	}
	h1.listing + .post-meta::after {
		width: 100%;
		top: 36px;
	}
	h1.listing + .post-meta > * {
		margin: 0;
	}
	h1.listing + .post-meta .karma-value,
	h1.listing + .post-meta .comment-count,
	h1.listing + .post-meta .lw2-link,
	h1.listing + .post-meta .read-time {
		top: unset;
		bottom: -2px;
	}
	h1.listing + .post-meta .karma-value {
		right: 250px;
	}
	h1.listing + .post-meta .comment-count {
		right: 175px;
	}
	h1.listing + .post-meta .read-time {
		right: 75px;
	}
	h1.listing + .post-meta .lw2-link {
		right: 0;
		opacity: 1;
	}
}

h1.listing + .post-meta .comment-count.new-comments::before {
	color: #009100;
	text-shadow: 0.5px 0.5px 0.5px #fff;
}
h1.listing + .post-meta .comment-count.new-comments:hover::before {
	text-shadow: 0.5px 0.5px 0.5px #999;
}

/*==================*/
/* POSTS & COMMENTS */
/*==================*/

.post-body,
.comment-body,
.posting-controls textarea {
	font-family: Charter, Georgia, serif;
}

/*===========================*/
/* COMMENTING AND POSTING UI */
/*===========================*/

.guiedit-buttons-container button {
	font-family: Font Awesome, Charter, Georgia, serif;
}