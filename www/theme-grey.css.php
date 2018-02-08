/**************/
/* GREY THEME */
/**************/

body {
    background: #eee;
}

#content {
    box-shadow: 0px 0px 10px #bbb;
}

h1.listing {
	margin: 0.6em 20px 0.1em 20px;
}
h1.listing a {
    font-size: 1.5rem;
    color: #f60;
}
.listing a[href^='/'] {
	font-weight: normal;
	display: inline;
}
h1.listing a[href^='http'] {
	font-size: 1.125rem;
	top: 10px;
	color: #999;
	opacity: 0.7;
}

h1.listing + .post-meta * {
    color: #222;
    font-size: 1em;
}

h1.listing + .post-meta .karma {
    float: left;
    margin-right: 3px;
}

h1.listing + .post-meta .karma::after {
    content: " by";
}

h1.listing + .post-meta .author {
    margin-right: 0;
}

h1.listing + .post-meta .date::before {
    content: "on ";
}

h1.listing + .post-meta .date::after {
    content: " — ";
	opacity: 0.5;
}

h1.listing + .post-meta .date {
    margin-right: 5px;
}

h1.listing + .post-meta .comment-count {
    margin-left: 0;
    margin-right: 4px;
}

h1.listing + .post-meta .lw2-link {
	margin-left: 10px;
}

.nav-item a:link,
.nav-item a:visited {
    font-weight: normal;
    color: #888;
}

.nav-inner::after {
    display: none;
}

#secondary-bar .nav-item {
    font-size: 0.875rem;
}

#primary-bar .nav-item {
    font-size: 0.875rem;
}

#nav-item-search form::before {
    opacity: 0.4;
	font-size: 0.9375rem;
}

.nav-bar a, 
#nav-item-search button, 
.button, 
.button:visited, 
.rss,
.rss:visited {
    color: #999;
}

a:hover {
    text-shadow: none;
}

.post > h1:first-child {
	margin: 1.1em 0 0.25em 0;
	font-weight: 400;
	color: #222;
	font-size: 3em;
}
.post-meta a,
.post-meta .author,
.post-meta .date {
	color: #222;
}
.post-meta .upvote::before,
.comment-meta .upvote::before {
	content: "\F077";
}
.post-meta .downvote::before,
.comment-meta .downvote::before {
	content: "\F078";
	position: relative;
	left: -2px;
	top: 1px;
}
.upvote:hover,
.upvote.selected {
	text-shadow:
		0 0 0.5px #fff, 
		0 0 8px #0f0;
}
.downvote:hover,
.downvote.selected {
	text-shadow:
		0 0 0.5px #fff, 
		0 0 8px #f00;
}
.post-meta .lw2-link,
.comment-meta .lw2-link {
	opacity: 0.5;
}
.post-body a:link,
.comment-body a:link {
	color: #f60;
}
.post-body a:visited,
.comment-body a:visited {
	color: #ff943b;
}
.post-body,
.comment-body {
	font-family: Source Sans Pro, Trebuchet MS, Helvetica, Arial, Verdana, sans-serif;
	font-weight: 400;
}
@-moz-document url-prefix() {
	.post-body, .comment-body {
		font-weight: <?php global $platform; echo ($platform == 'Windows' ? '300' : '400'); ?>;
	}
}
.post-body {
	font-size: 1.1875rem;
	line-height: 1.6;
}
@media (-webkit-max-device-pixel-ratio: 1), (max-resolution: 191dpi) { 
	.post-body {
		font-size: 1.125rem;
	}
}
.comment-body {
	font-size: 1.125rem;
}
.comment-meta a {
	color: #222;
}
.comment-meta .author {
	color: #999;
	font-weight: 600;
}

button,
input[type='submit'] {
	color: #f60;
}
.guiedit-buttons-container button {
	color: #00e;
}
#markdown-hints-checkbox + label {
	color: #999;
}

#theme-selector button,
#width-selector button {
	box-shadow:
		0 0 0 4px #eee inset,
		0 0 0 5px #ccc inset;
}
#theme-selector button:hover,
#theme-selector button.selected,
#width-selector button:hover,
#width-selector button.selected {
	box-shadow:
		0 0 0 5px #ccc inset;
}
#bottom-bar a[href='#top']:hover::after,
.post-meta a[href='#comments']:hover::after,
.post-meta a[href='#bottom-bar']:hover::after  {
	color: #000;
	background-color: #d8d8d8;
}

.new-comment::before {
	outline: 2px solid #9037ff;
	box-shadow:
		0 0 6px -2px #9037ff inset, 
		0 0 4px #9037ff, 
		0 0 6px #9037ff;
}

.archive-nav a:link,
.archive-nav a:visited {
	color: #888;
}
#content.search-results-page .post-meta .author, 
#content.user-page .post-meta .author {
	font-weight: normal;
}
#content.search-results-page h1.listing a[href^='http'],
#content.user-page h1.listing a[href^='http'] {
	top: 6px;
}

.contents {
	padding-right: 0.5em;
}
.post-body .contents a:link {
	color: #d64400;
}
.post-body .contents ul {
	font-size: 0.85em;
}	