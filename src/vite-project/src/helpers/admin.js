export function ClientCreatedToNowMonths(clientcreationdate) {
    let creationdate = new Date(clientcreationdate);
    let currentdate = new Date();

    const Difference_In_Time = currentdate.getTime() - creationdate.getTime();
      
    const Difference_In_Days = Difference_In_Time / (1000 * 3600 * 24);
    const FullMonths = Math.floor(Difference_In_Days / 30)

    return FullMonths
}
