export default function printError(error) {
    var errors = Object.values(error.response.data.errors);
    errors.forEach(element => {
        alert(element) 
    });
}