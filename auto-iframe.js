function AutoiFrameAdjustiFrameHeight( id, fudge )
      {
      var frame = document.getElementById( id );
      var content = jQuery('.embed-wrap');
      var height = frame.contentDocument.body.offsetHeight + fudge;

      content.height( height );
      frame.height = height;
      }
