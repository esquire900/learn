/**
 * Unused for now.
 * 
 * @constructor
 */
mindmaps.NewDocumentView = function() {

};

/**
 * Creates a new NewDocumentPresenter. This presenter has no view associated
 * with it for now. It simply creates a new document. It could in the future
 * display a dialog where the user could chose options like document title and
 * such.
 * 
 * @constructor
 */
mindmaps.NewDocumentPresenter = function(eventBus, mindmapModel, view) {

  this.go = function() {
    
	var id, url;
	id = window.location.search.replace('?id=', '');
	console.log(id);
	if (!isNaN(parseFloat(id)) && isFinite(id)) {
		url = "API/getMindMap?id=" + id;
		$.ajax({
			url: url,
			success: function(data) {
				var doc;
				doc = mindmaps.Document.fromObject(data);
				mindmapModel.setDocument(data);
				return 0;
			},
			failure: function(errMsg) {
				console.log(errMsg);
				return 0;
			}
		});
	}else{
		var doc = new mindmaps.Document();
		mindmapModel.setDocument(doc);
	}
        
  };
};
