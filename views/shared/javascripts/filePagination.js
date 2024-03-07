
jQuery(function($) {
    var pagination = $('#file-pagination')
    if (!pagination.length) return;
    var items = $(".single-file");
	
    var numItems = items.length;
    var perPage = 1;
    var theme = pagination.data("theme");
	var prevText = pagination.data("prevtext");
	var nextText = pagination.data("nexttext");

    items.slice(perPage).hide();

    function checkFragment() {
        var hash = window.location.hash || "#page-1";
        hash = hash.match(/^#page-(\d+)$/);
        if(hash) {
            pagination.pagination("selectPage", parseInt(hash[1]));
        }
    };
	
	if(numItems > 1){
		pagination.pagination({
			items: numItems,
			itemsOnPage: perPage,
			cssStyle: theme,
			prevText: prevText,
			nextText: nextText,

			onPageClick: function(pageNumber) {
				var showFrom = perPage * (pageNumber - 1);
				var showTo = showFrom + perPage;

				items.hide()
				.slice(showFrom, showTo).show();
			}
		});
		$(window).bind("popstate", checkFragment);
		checkFragment();
	}
});
