function insertTiny(url, title) {
      if (url != "" && title != "") {
            var textToInsert = '<strong>Baca juga: <a target="_self" href="' + url + '">' + title + '</a><strong>';
            // Insert the contents from the input into the document
            parent.tinymce.activeEditor.execCommand('mceInsertContent', false, textToInsert);
            parent.tinymce.activeEditor.windowManager.close();
      } else {
            alert("Terjadi Kesalahan");
      }
}