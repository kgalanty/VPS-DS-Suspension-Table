import { ClientCreatedToNowMonths } from './admin'
import { addDays, formatDateShort } from './formatDate'

export function showSuspensionTicketDate(duedate, clientcreationdate, isvpsds) {
    if(ClientCreatedToNowMonths(clientcreationdate) < 12)
    {
        const suspendTicket = isvpsds ? addDays(duedate, 2) : addDays(duedate, 2);
        return formatDateShort(suspendTicket)
    }
    else if(ClientCreatedToNowMonths(clientcreationdate) < 24)
    {
        const suspendTicket = addDays(duedate, 4);
        return formatDateShort(suspendTicket)
    }
    else if(ClientCreatedToNowMonths(clientcreationdate) >= 24)
    {
        const suspendTicket = isvpsds ? addDays(duedate, 6) : addDays(duedate, 4);
        return formatDateShort(suspendTicket)
    }
}

export function showTerminationTicketDate(duedate, clientcreationdate, isvpsds) {
    if(ClientCreatedToNowMonths(clientcreationdate) < 12)
    {
        const suspendTicket = isvpsds ? addDays(duedate, 6) : addDays(duedate, 5);
        return formatDateShort(suspendTicket)
    }
    else if(ClientCreatedToNowMonths(clientcreationdate) < 24)
    {
        const suspendTicket = isvpsds ? addDays(duedate, 9) : addDays(duedate, 6);
        return formatDateShort(suspendTicket)
    }
    else if(ClientCreatedToNowMonths(clientcreationdate) >= 24 )
    {
        const suspendTicket = isvpsds ? addDays(duedate, 13) : addDays(duedate, 6);
        return formatDateShort(suspendTicket)
    }
}