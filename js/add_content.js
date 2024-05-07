function signout() {
    location.href = "logout.php";
}
function addform() {
    //type = document.getElementsById("addbutton").value;
    document.getElementById("addform").innerHTML=`<hr>
    <form action='#' method='POST'>
        <table>
            <tr>
                <td>Action</td>
                <td>
                    <select name='type'>
                        <option value='meeting'>Schedule a meeting</option>
                        <option value='note'>Add a note</option>
                        <option value='assignment'>Assign a task</option>
                        <option value='exam'>Schedule an exam</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Topic</td>
                <td><input type='text' name='topic'></td>
            </tr>
            <tr>
                <td>Link</td>
                <td><input type='url' name='link'></td>
            </tr>
            <tr>
                <td>Date</td>
                <td><input type='datetime-local' name='date_time'></td>
            </tr>
            <tr><td colspan='2'><button type='submit' name='add'>Submit</button></td></tr>
        </table>
    </form>`;
}