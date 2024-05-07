function success(){
    fname = document.getElementById("fname").value;
    designation = 'Student';
    isteacher = document.getElementsByName("teacher").checked;
    if(isteacher)
        designation = 'Teacher';
    subject = document.getElementById("stream").value;
    alert(`Hey ${fname}! You have successfully registered for ${subject} as a ${designation}`);
}
