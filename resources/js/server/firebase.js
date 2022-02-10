import firebase from "firebase/app";
import "firebase/auth";

const firebaseConfig = {
    apiKey: "AIzaSyAN0sN-WbOIYFmGngH-99fZOTaE0n6Hb_c",
    authDomain: "bc-gim.firebaseapp.com",
    databaseURL: "https://bc-gim.firebaseio.com",
    projectId: "bc-gim",
    storageBucket: "bc-gim.appspot.com",
    messagingSenderId: "815072522968",
    appId: "1:815072522968:web:77a50fe685fadc90da1dad"
};
  // Initialize Firebase
//firebase.initializeApp(firebaseConfig);

//const auth = firebase.auth;

//export {auth, firebase}


export default firebase.initializeApp(firebaseConfig);
