(self.webpackChunk=self.webpackChunk||[]).push([["src_js_modules_wp-editor_js"],{580:i=>{var t={initTinyMCE:function(){wp.editor.remove("discussion"),wp.editor.initialize("discussion",{tinymce:!0,teeny:!0,quicktags:!0})},init:function(){jQuery("body").on("click",".wc-tabs li a, ul.tabs li a",(function(i){setTimeout(t.initTinyMCE,150)})),jQuery(document).ready((function(){setTimeout(t.initTinyMCE,150)})),jQuery("body").on("alg_dtwp_comments_loaded",t.initTinyMCE),jQuery(document).on("click",".comment-reply-link,#cancel-comment-reply-link",(function(i){setTimeout(t.initTinyMCE,150)})),jQuery(document).on("tinymce-editor-setup",t.setupEditor)},setupEditor:function(i,t){if("discussion"===t.id){var n=t.settings.toolbar1.split(",");n=n.filter((function(i){return-1===["bullist","numlist"].indexOf(i)})),t.settings.toolbar1=n.join()}}};i.exports=t}}]);