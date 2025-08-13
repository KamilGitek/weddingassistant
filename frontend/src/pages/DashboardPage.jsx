import React from 'react';
import { useAuth } from '../contexts/AuthContext';
import './DashboardPage.css';

const DashboardPage = () => {
  const { user, logout } = useAuth();

  const modules = [
    {
      icon: '📋',
      title: 'Checklist',
      description: 'Zarządzaj listami zadań do planowania wesela',
      status: 'active'
    },
    {
      icon: '👥',
      title: 'Rejestr Gości',
      description: 'Lista gości i zarządzanie potwierdzeniami',
      status: 'coming-soon'
    },
    {
      icon: '🪑',
      title: 'Planer Stołów',
      description: 'Układ miejsc i organizacja stołów',
      status: 'coming-soon'
    },
    {
      icon: '💰',
      title: 'Planer Kosztów',
      description: 'Budżet i śledzenie wydatków',
      status: 'coming-soon'
    },
    {
      icon: '🌐',
      title: 'Strona Wesela',
      description: 'Tworzenie strony internetowej wesela',
      status: 'coming-soon'
    },
    {
      icon: '📱',
      title: 'Mobilny Dostęp',
      description: 'Aplikacja mobilna w przygotowaniu',
      status: 'coming-soon'
    }
  ];

  return (
    <div className="dashboard-page">
      <div className="container">
        {/* Welcome Header */}
        <div className="dashboard-header">
          <div className="welcome-section">
            <h1>Witaj, {user?.first_name || 'Użytkowniku'}! 👋</h1>
            <p>Rozpocznij planowanie swojego wymarzonego wesela</p>
          </div>
          <div className="user-info">
            <div className="user-avatar">
              {user?.first_name?.charAt(0) || user?.email?.charAt(0) || 'U'}
            </div>
            <div className="user-details">
              <span className="user-name">{user?.first_name} {user?.lastName}</span>
              <span className="user-email">{user?.email}</span>
            </div>
          </div>
        </div>

        {/* Quick Stats */}
        <div className="stats-section">
          <div className="grid grid-4">
            <div className="stat-card">
              <div className="stat-icon">📋</div>
              <div className="stat-content">
                <div className="stat-number">0</div>
                <div className="stat-label">Aktywne checklisty</div>
              </div>
            </div>
            <div className="stat-card">
              <div className="stat-icon">👥</div>
              <div className="stat-content">
                <div className="stat-number">0</div>
                <div className="stat-label">Zarejestrowani goście</div>
              </div>
            </div>
            <div className="stat-card">
              <div className="stat-icon">💰</div>
              <div className="stat-content">
                <div className="stat-number">0 PLN</div>
                <div className="stat-label">Wydatki</div>
              </div>
            </div>
            <div className="stat-card">
              <div className="stat-icon">📅</div>
              <div className="stat-content">
                <div className="stat-number">-</div>
                <div className="stat-label">Data wesela</div>
              </div>
            </div>
          </div>
        </div>

        {/* Modules Grid */}
        <div className="modules-section">
          <h2>Dostępne moduły</h2>
          <div className="grid grid-3">
            {modules.map((module, index) => (
              <div key={index} className={`module-card ${module.status}`}>
                <div className="module-icon">{module.icon}</div>
                <div className="module-content">
                  <h3>{module.title}</h3>
                  <p>{module.description}</p>
                  <div className="module-status">
                    {module.status === 'active' ? (
                      <span className="status-active">Dostępny</span>
                    ) : (
                      <span className="status-coming-soon">Wkrótce dostępny</span>
                    )}
                  </div>
                </div>
              </div>
            ))}
          </div>
        </div>

        {/* Quick Actions */}
        <div className="quick-actions">
          <h2>Szybkie akcje</h2>
          <div className="actions-grid">
            <button className="action-btn">
              <span className="action-icon">➕</span>
              <span>Utwórz nową checklistę</span>
            </button>
            <button className="action-btn">
              <span className="action-icon">👤</span>
              <span>Dodaj gościa</span>
            </button>
            <button className="action-btn">
              <span className="action-icon">💰</span>
              <span>Dodaj wydatek</span>
            </button>
            <button className="action-btn">
              <span className="action-icon">📝</span>
              <span>Notatki</span>
            </button>
          </div>
        </div>
      </div>
    </div>
  );
};

export default DashboardPage;
