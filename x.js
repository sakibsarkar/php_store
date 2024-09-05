function cipher(txt) {
  const alphabets = Array.from({ length: 26 }, (_, i) =>
    String.fromCharCode(i + 65)
  );
  const letters = txt.split("");

  const length = txt.length;
  let result = "";
  letters.forEach((ltr) => {
    const indx = alphabets.indexOf(ltr.toUpperCase());

    if (ltr === " ") {
      result += ltr;
    } else {
      const newltr = alphabets[(indx + 3) % 26];
      result += newltr;
    }
  });

  return result;
}

function decoder(txt) {
    const alphabets = Array.from({ length: 26 }, (_, i) =>
        String.fromCharCode(i + 65)
      );
      const letters = txt.split("");
    
      const length = txt.length;
      let result = "";
      letters.forEach((ltr) => {
        const indx = alphabets.indexOf(ltr.toUpperCase());
    
        if (ltr === " ") {
          result += ltr;
        } else {
          const newltr = alphabets[(indx - 3) % 26];
          result += newltr;
        }
      });
    
      return result;
  
}

console.log(decoder("KHOOR IVDIGVI"));
