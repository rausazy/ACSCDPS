import React from 'react';
import ReactDOM from 'react-dom/client';
import {
  LineChart,
  Line,
  XAxis,
  YAxis,
  CartesianGrid,
  Tooltip,
  ResponsiveContainer
} from 'recharts';

// Sample data
const data = [
  { name: 'Jan', sales: 400 },
  { name: 'Feb', sales: 300 },
  { name: 'Mar', sales: 500 },
  { name: 'Apr', sales: 200 },
  { name: 'May', sales: 600 },
  { name: 'Jun', sales: 350 },
  { name: 'Jul', sales: 700 },
  { name: 'Aug', sales: 450 },
  { name: 'Sep', sales: 500 },
  { name: 'Oct', sales: 650 },
  { name: 'Nov', sales: 550 },
  { name: 'Dec', sales: 800 },
];

const Chart = () => (
  <ResponsiveContainer width="100%" height="100%">
    <LineChart data={data}>
      <CartesianGrid strokeDasharray="3 3" />
      <XAxis dataKey="name" />
      <YAxis />
      <Tooltip />
      <Line type="monotone" dataKey="sales" stroke="#6366f1" strokeWidth={3} />
    </LineChart>
  </ResponsiveContainer>
);

if (document.getElementById('analytics-chart')) {
  const root = ReactDOM.createRoot(document.getElementById('analytics-chart'));
  root.render(<Chart />);
}
