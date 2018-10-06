/*****************/
/* EMBEDDED MODE */
/*****************/

#content.embedded-mode ~ #ui-elements-container,
#content.embedded-mode > .nav-bar,
#content.embedded-mode > .page-toolbar,
#content.embedded-mode > #top-nav-bar,
#content.embedded-mode > #comments-list-mode-selector,
#content.embedded-mode > .sublevel-nav {
	display: none;
}
#content.embedded-mode {
	padding: 0 2px;
	min-width: 100%;
	overflow: visible;
	align-content: start;
}

/*= Comments =*/

#content.embedded-mode .comment-thread {
	margin: 0 0 0.5em 0;
}
#content.embedded-mode .comment-thread .comment-item {
	border-width: 1px 0 0 0;
	background-color: transparent;
}
#content.embedded-mode .comment-thread .comment,
#content.embedded-mode .comment-thread .comment-body {
	overflow: hidden;
}
#content.embedded-mode .comment-thread .comment-body {
	font-size: 1em;
	padding: 4px;
	line-height: 1.25;
	max-height: 44px;
}
#content.embedded-mode .comment-meta {
	font-size: 0.9375em;
	padding: 4px;
}
#content.embedded-mode .comment-meta .karma,
#content.embedded-mode .comment-meta .lw2-link {
	display: none;
}
#content.embedded-mode .comment-meta .author {
	max-width: 144px;
	overflow: hidden;
	text-overflow: ellipsis;
}
#content.embedded-mode .comment-meta .author:hover {
	overflow: visible;
	z-index: 1;
	text-shadow: 
		0 0  1px #fff,
		0 0  3px #fff,
		0 0  5px #fff,
		0 0  8px #fff,
		0 0 13px #fff,
		0 0 21px #fff;
}
#content.embedded-mode .comment-post-title > span {
	display: block;
	overflow: hidden;
	text-overflow: ellipsis;
}

/*= Posts =*/

#content.embedded-mode h1.listing {
	margin: 0;
	padding: 0.25em 4px 0 4px;
	max-width: 100%;
	border-top: 1px solid #ddd;
	font-size: 1.5em;
	font-weight: 600;
}

#content.embedded-mode h1.listing + .post-meta {
	padding: 3px 0 0 0;
	margin: 4px 6px;
}
#content.embedded-mode h1.listing + .post-meta::after {
	display: none;
}
#content.embedded-mode h1.listing + .post-meta .karma,
#content.embedded-mode h1.listing + .post-meta .read-time,
#content.embedded-mode h1.listing + .post-meta .lw2-link,
#content.embedded-mode h1.listing + .post-meta .link-post-domain,
#content.embedded-mode h1.listing + .post-meta .post-section {
	display: none;
}
#content.embedded-mode h1.listing + .post-meta > * {
	position: static;
}
#content.embedded-mode h1.listing + .post-meta .comment-count {
	box-shadow: none;
	line-height: unset;
}
#content.embedded-mode h1.listing + .post-meta .comment-count::before {
	box-shadow: none;
}
#content.embedded-mode h1.listing + .post-meta .comment-count:hover {
	background-color: initial;
	color: #0a0;
}

/***********/
/* SIDEBAR */
/***********/

#content > #primary-bar,
#content > #secondary-bar {
	grid-column: 1 / span 4;
}
#secondary-content-column {
	grid-column: 4;
	grid-row: 3 / span 1000;
	display: flex;
	flex-flow: column;
	margin: 0 -30px 0 30px;
	box-shadow:
		1px 0 0 0 #ddd inset;
}
#secondary-content-column .content-area {
	padding: 0 1px 0 2px;
	display: flex;
	flex-flow: column;
	border-style: solid;
	border-color: #ddd;
	border-width: 0 0 1px 0;
	position: relative;
}
#secondary-content-column .content-area::after {
	content: "";
	display: block;
	position: absolute;
	left: 1px;
	right: 1px;
	height: 60px;
	background-image: linear-gradient(to top, #fff, rgba(255,255,255,0.75) 75%, rgba(255,255,255,0.25) 75%);
	bottom: 36px;
}
#secondary-content-column .content-area.recent-posts {
	height: 480px;
}
#secondary-content-column .content-area.recent-comments {
	height: 1268px;
}
#secondary-content-column .content-area object {
	height: 100%;
}
#secondary-content-column .content-area > h1 {
	margin: -1px;
	padding: 0.5em 0 0.5em 0;
	font-size: 1.5rem;
	font-weight: 600;
	line-height: 1;
	text-align: center;
	border-style: solid;
	border-color: #ddd;
	border-width: 1px 0;
	background-color: #eee;
}
#secondary-content-column .content-area > h1 span {
	background-color: #888;
    -webkit-background-clip: text;
    -moz-background-clip: text;
    background-clip: text;
    color: transparent;
    text-shadow: rgba(255,255,255,0.5) 0px 3px 3px;
}
#secondary-content-column .content-area > p {
	text-align: right;
	margin: 0;
	padding: 4px 16px;
	font-size: 1.25em;
}
#secondary-content-column .content-area > p a {
	color: #999;
}