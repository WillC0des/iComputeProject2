/* Fetching Data */

function fetchData(filePath, storage) {
  console.log("Fetching data...");

  $.ajax({
    type: "GET",
    url: filePath,
    dataType: "text",

    success: function(data) { // Success.
      console.log("...fetch success.");

      formatData(data, storage);
    },

    fail: function() { // Failure.
      console.log("...fetch failure.");
    },

    always: function() { // ALways.

    }
  });
}

function formatData(data, storage) {
  var dataArr = data.trim().split("\n");
  var headings = dataArr[0].split(";");

  for (var i = 1; i < dataArr.length; i++) {
    var row = dataArr[i].trim().split(";");
    var currentData = {};

    for (var j = 0; j < headings.length; j++) {
      currentData[headings[j]] = row[j].trim();
    }

    storage.push(currentData);
  }
}

/* Submitting Data */

function convertToCsv(storage) {
  var objArray = JSON.stringify(storage);

  var array = typeof objArray != 'object' ? JSON.parse(objArray) : objArray;
  var str = '';

  // Store the headings.
  var headings = Object.keys(array[0]);

  for (var i = 0; i < headings.length; i++) {
    str += headings[i].trim();

    if (i != headings.length - 1) {
      str += ';'
    }
  }

  str += '\n';

  // Store the data.
  for (var i = 0; i < array.length; i++) {
    var line = '';

    for (var index in array[i]) {
      if (line != '') {
        line += ';';
      }

      line += array[i][index];
    }

    str += line + '\r\n';
  }

  console.log(str);

  return str;
}

function submitData(filePath, storage) {
  console.log("Submitting data...");

  $.ajax({
    type: "POST",
    url: filePath,
    data: {
      "data": convertToCsv(storage)
    },
    // dataType: "text",

    success: function() { // Success.
      console.log("...submission success.");
    },

    fail: function() { // Failure.
      console.log("...submission failure.");
    },

    always: function() { // Always.

    }
  });
}
