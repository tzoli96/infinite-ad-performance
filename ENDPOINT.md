## **Campaign API - Documentation**
This API provides endpoints for managing **campaigns**, **campaign metrics**, and **analytics**.

---

## **1. Campaign Endpoints**
### **1.1 Get All Campaigns**
- **URL:** `GET /api/campaigns`
- **Description:** Fetches all campaigns.
- **Params:** None.
- **Response:** List of campaigns.

### **1.2 Create a Campaign**
- **URL:** `POST /api/campaigns`
- **Description:** Creates a new campaign.
- **Headers:**
  ```json
  { "Content-Type": "application/json" }
  ```
- **Body:**
  ```json
  {
    "name": "Black Friday Sale",
    "status": "active",
    "daily_budget": 100.0,
    "start_date": "2024-11-01",
    "end_date": "2024-12-01"
  }
  ```

### **1.3 Update a Campaign**
- **URL:** `PUT /api/campaigns/{id}`
- **Description:** Updates an existing campaign.
- **Body:**
  ```json
  {
    "name": "Cyber Monday Sale",
    "status": "paused",
    "daily_budget": 150.0,
    "start_date": "2024-12-01",
    "end_date": "2024-12-10"
  }
  ```

### **1.4 Delete a Campaign**
- **URL:** `DELETE /api/campaigns/{id}`
- **Description:** Deletes a campaign.
- **Params:** `{id}` (campaign ID).

---

## **2. Campaign Metrics Endpoints**
### **2.1 Create Campaign Metrics**
- **URL:** `POST /api/campaign-metrics`
- **Description:** Adds performance data to a campaign.
- **Body:**
  ```json
  {
    "campaign_id": 2,
    "date": "2024-11-03",
    "impressions": 5000,
    "clicks": 250,
    "spend": 120.5,
    "conversions": 20
  }
  ```

### **2.2 Get Campaign Metrics**
- **URL:** `GET /api/campaign-metrics/{id}?start_date=YYYY-MM-DD&end_date=YYYY-MM-DD`
- **Description:** Fetches performance metrics for a campaign.
- **Params:**
    - `{id}`: Campaign ID
    - `start_date`: Start date (optional)
    - `end_date`: End date (optional)

---

## **3. Analytics Endpoints**
### **3.1 Get Performance Analytics**
- **URL:** `GET /api/analytics/performance?start_date=YYYY-MM-DD&end_date=YYYY-MM-DD`
- **Description:** Retrieves performance analytics for a given period.
- **Params:**
    - `start_date`: Start date
    - `end_date`: End date

---

## **Endpoint Summary**
| Method | Endpoint | Description |
|--------|----------|-------------|
| `GET` | `/api/campaigns` | Fetch all campaigns |
| `POST` | `/api/campaigns` | Create a campaign |
| `PUT` | `/api/campaigns/{id}` | Update a campaign |
| `DELETE` | `/api/campaigns/{id}` | Delete a campaign |
| `POST` | `/api/campaign-metrics` | Add campaign metrics |
| `GET` | `/api/campaign-metrics/{id}` | Fetch campaign metrics |
| `GET` | `/api/analytics/performance` | Fetch analytics |

---
