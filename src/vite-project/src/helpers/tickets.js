import { ClientCreatedToNowMonths } from './admin'
import { addDays, formatDateShort } from './formatDate'

export function showSuspensionTicketDate(duedate, clientcreationdate, isvpsds) {
    if(ClientCreatedToNowMonths(clientcreationdate) < 12)
    {
        const suspendTicket = isvpsds ? addDays(duedate, 3) : addDays(duedate, 3);
        return formatDateShort(suspendTicket)
    }
    else if(ClientCreatedToNowMonths(clientcreationdate) < 24)
    {
        const suspendTicket = addDays(duedate, 5);
        return formatDateShort(suspendTicket)
    }
    else if(ClientCreatedToNowMonths(clientcreationdate) >= 24)
    {
        const suspendTicket = isvpsds ? addDays(duedate, 7) : addDays(duedate, 5);
        return formatDateShort(suspendTicket)
    }
}

export function showTerminationTicketDate(duedate, clientcreationdate, isvpsds) {
    if(ClientCreatedToNowMonths(clientcreationdate) < 12)
    {
        const suspendTicket = isvpsds ? addDays(duedate, 14) : addDays(duedate, 5);
        return formatDateShort(suspendTicket)
    }
    else if(ClientCreatedToNowMonths(clientcreationdate) < 24)
    {
        const suspendTicket = isvpsds ? addDays(duedate, 17) : addDays(duedate, 6);
        return formatDateShort(suspendTicket)
    }
    else if(ClientCreatedToNowMonths(clientcreationdate) >= 24 )
    {
        const suspendTicket = isvpsds ? addDays(duedate, 21) : addDays(duedate, 6);
        return formatDateShort(suspendTicket)
    }
}
