const API_URL = '../booking/api.php';

document.addEventListener('DOMContentLoaded', loadBookings);

async function loadBookings() {
    try {
        const response = await fetch(`${API_URL}?action=get_bookings`);
        const bookings = await response.json();
        renderBookings(bookings);
    } catch (error) {
        showMessage('Error loading bookings', 'error');
        document.getElementById('bookings-list').innerHTML = 
            '<div class="no-bookings">Failed to load bookings.</div>';
    }
}

function renderBookings(bookings) {
    const container = document.getElementById('bookings-list');
    
    if (bookings.length === 0) {
        container.innerHTML = '<div class="no-bookings">No booking requests.</div>';
        return;
    }
    
    container.innerHTML = bookings.map(booking => `
        <div class="booking-request" data-id="${booking.id}">
            <div class="details">
                <p><strong>Customer name:</strong> ${escapeHtml(booking.customer_name)}</p>
                <p><strong>Phone no.:</strong> ${escapeHtml(booking.phone)}</p>
                <p><strong>Package:</strong> ${escapeHtml(booking.package)}</p>
                <p><strong>Backdrop color:</strong> ${escapeHtml(booking.backdrop_color)}</p>
                <p><strong>Reference No.:</strong> ${escapeHtml(booking.reference_no)}</p>
                <p><strong>Booking Date:</strong> ${formatDate(booking.booking_date)}</p>
                <p><strong>Time slot:</strong> ${escapeHtml(booking.time_slot)}</p>
            </div>
            <div class="receipt-placeholder">
                <p>E-Payment Receipt:</p>
                <div class="receipt-box" onclick="viewReceipt(${booking.id})"></div>
            </div>
            <div class="actions">
                <button class="confirm" onclick="confirmBooking(${booking.id})" ${booking.status !== 'pending' ? 'disabled' : ''}>
                    Confirm
                </button>
                <button class="delete" onclick="deleteBooking(${booking.id})">Delete</button>
            </div>
        </div>
    `).join('');
}

async function confirmBooking(id) {
    if (!confirm('Confirm this booking?')) return;
    
    try {
        const response = await fetch(`${API_URL}?action=confirm_booking`, {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `id=${id}`
        });
        
        const result = await response.json();
        
        if (result.success) {
            showMessage('Booking confirmed!', 'success');
            // Update button state
            const btn = document.querySelector(`.booking-request[data-id="${id}"] .confirm`);
            if (btn) {
                btn.disabled = true;
                btn.textContent = 'Confirmed';
            }
        }
    } catch (error) {
        showMessage('Error confirming booking', 'error');
    }
}

async function deleteBooking(id) {
    if (!confirm('Delete this booking?')) return;
    
    try {
        const response = await fetch(`${API_URL}?action=delete_booking`, {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `id=${id}`
        });
        
        const result = await response.json();
        
        if (result.success) {
            showMessage('Booking deleted!', 'success');
            const card = document.querySelector(`.booking-request[data-id="${id}"]`);
            if (card) {
                card.style.opacity = '0';
                card.style.transform = 'translateX(20px)';
                setTimeout(() => card.remove(), 300);
            }
        }
    } catch (error) {
        showMessage('Error deleting booking', 'error');
    }
}

function viewReceipt(id) {
    alert(`View receipt for booking #${id}`);
}

function showMessage(msg, type) {
    const area = document.getElementById('message-area');
    area.innerHTML = `<div class="${type}-message">${escapeHtml(msg)}</div>`;
    setTimeout(() => area.innerHTML = '', 3000);
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

function formatDate(dateStr) {
    return new Date(dateStr).toLocaleDateString('en-US', {
        year: 'numeric', 
        month: 'long', 
        day: 'numeric'
    });
}