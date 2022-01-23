
 var promise = new Promise(function(resolve, reject) {
      var a=1;
    if (a==1) {
      resolve("Success!");
    } else {
      throw "Failure!";
    }
  }
    );

  promise.then(function(result) {
      console.log("MyResult:" + result);
      return "First Then Result";
    }).then((firstResult) => {
        console.log("First Result:" + firstResult);
        return "Second Then Result";
    }).then ((secondResult) => {
        console.log("Second Result:" + secondResult);
    })
    .catch(function() {
      console.log("MyError:");
    })



