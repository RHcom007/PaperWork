import Excalidraw from "@excalidraw/excalidraw";
import "@excalidraw/excalidraw/dist/excalidraw.min.css";

window.addEventListener("DOMContentLoaded", () => {
  const excalidrawWrapper = document.getElementById("excalidraw-wrapper");

  if (excalidrawWrapper) {
    const excalidraw = new Excalidraw({
      element: excalidrawWrapper,
      // other options here
    });
  }
});
