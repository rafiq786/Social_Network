imgInp.onchange = evt => {
    const [file] = imgInp.files
    if (file) {
        prev_img.style.display = "block";
        prev_txt.style.display = "block";
      prev_img.src = URL.createObjectURL(file)
    }
  }