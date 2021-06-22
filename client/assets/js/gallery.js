window.addEventListener("resize", recalculateLayout);

function recalculateLayout(){
    const gallery = document.getElementById("gallery");
    const gallery_horizontal = document.getElementById("gallery-horizontal");
    const aspectRatio = 16 / 9;
    const buttonsBarHeight = 74;
    const screenWidth = document.body.getBoundingClientRect().width;
    const screenHeight = document.body.getBoundingClientRect().height - buttonsBarHeight;
    const videoCount = document.getElementsByClassName("user-box").length;
    const desktopCount = document.getElementsByClassName("desktop-box").length;

    const values = calculateLayout(
        screenWidth,
        screenHeight,
        desktopCount ? desktopCount : videoCount,
        aspectRatio
      );

      gallery.style.setProperty("--width", values.width + "px");
      gallery.style.setProperty("--height", values.height + "px");
      gallery.style.setProperty("--cols", values.cols + "");
      gallery.style.setProperty("--rows", values.rows + "");

    function calculateLayout(containerWidth, containerHeight, videoCount, aspectRatio){
        let bestLayout = {
            area: 0,
            cols: 0,
            rows: 0,
            width: 0,
            height: 0
          };
    
        // brute-force search layout where video occupy the largest area of the container
        for (let cols = 1; cols <= videoCount; cols++) {
            const rows = Math.ceil(videoCount / cols);
            const hScale = (containerWidth) / (cols * aspectRatio);
            const vScale = (containerHeight) / rows;
            let width;
            let height;
            if (hScale <= vScale) {
              width = Math.floor((containerWidth) / cols);
              height = Math.floor(width / aspectRatio);
            } else {
              height = Math.floor((containerHeight) / rows);
              width = Math.floor(height * aspectRatio);
            }
            const area = width * height;
            if (area > bestLayout.area) {
              bestLayout = {
                area,
                width,
                height,
                rows,
                cols
              };
            }
          }

          moveUserBox(desktopCount);

          return bestLayout;
    }

    function moveUserBox(desktopCount){
        if(desktopCount){
            $('#gallery>.user-box').appendTo($('#gallery-horizontal'));

            const containerWidth = gallery_horizontal.getBoundingClientRect().width;

            console.log("moveUserBox: ", containerWidth);

            let width;
            let height;

            width = Math.floor(screenHeight/4);
            height = Math.floor(width/aspectRatio);

            gallery_horizontal.style.setProperty("--width", width + "px");
            gallery_horizontal.style.setProperty("--height", height + "px");
            
        } else if(gallery_horizontal.childElementCount > 0){
            $('#gallery-horizontal>.user-box').appendTo($('#gallery'));
        }
    }
}
