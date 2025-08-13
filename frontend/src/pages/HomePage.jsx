import React from 'react';
import { Link } from 'react-router-dom';
import './HomePage.css';

const HomePage = () => {
  const features = [
    {
      icon: '📋',
      title: 'Checklist',
      description: 'Inteligentne listy zadań do planowania wesela z gotowymi szablonami i przypomnieniami.'
    },
    {
      icon: '👥',
      title: 'Rejestr Gości',
      description: 'Zarządzaj listą gości, śledź potwierdzenia i organizuj miejsca przy stołach.'
    },
    {
      icon: '🪑',
      title: 'Planer Stołów',
      description: 'Wizualny planer układu stołów z możliwością dostosowania do potrzeb Twojego wesela.'
    },
    {
      icon: '💰',
      title: 'Planer Kosztów',
      description: 'Kontroluj budżet wesela, śledź wydatki i planuj finanse z precyzją.'
    },
    {
      icon: '🌐',
      title: 'Strona Wesela',
      description: 'Twórz piękną stronę internetową wesela z informacjami dla gości.'
    },
    {
      icon: '📱',
      title: 'Mobilny Dostęp',
      description: 'Dostęp do wszystkich funkcji z każdego urządzenia, w każdym miejscu.'
    }
  ];

  return (
    <div className="homepage">
      {/* Hero Section */}
      <section className="hero">
        <div className="hero-background">
          <div className="hero-overlay"></div>
        </div>
        <div className="container">
          <div className="hero-content">
            <h1 className="hero-title fade-in-up">
              Twój <span className="text-gold">Weselny Asystent</span>
            </h1>
            <p className="hero-subtitle fade-in-up">
              Kompleksowe narzędzie do planowania wymarzonego wesela. 
              Organizuj, planuj i ciesz się każdą chwilą przygotowań.
            </p>
            <div className="hero-buttons fade-in-up">
              <Link to="/register" className="btn btn-primary btn-large">
                Rozpocznij Planowanie
              </Link>
              <Link to="/login" className="btn btn-secondary btn-large">
                Zaloguj się
              </Link>
            </div>
          </div>
        </div>
      </section>

      {/* Features Section */}
      <section className="features">
        <div className="container">
          <div className="section-header text-center">
            <h2>Wszystko czego potrzebujesz w jednym miejscu</h2>
            <p>
              Wedding Assistant to kompleksowa platforma, która pomoże Ci 
              zorganizować wesele marzeń bez stresu i chaosu.
            </p>
          </div>
          
          <div className="grid grid-3">
            {features.map((feature, index) => (
              <div key={index} className="card card-feature fade-in-up" style={{animationDelay: `${index * 0.1}s`}}>
                <div className="icon">{feature.icon}</div>
                <h3>{feature.title}</h3>
                <p>{feature.description}</p>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* CTA Section */}
      <section className="cta">
        <div className="container">
          <div className="cta-content text-center">
            <h2>Gotowy na wesele marzeń?</h2>
            <p>
              Dołącz do tysięcy par, które już ufają Wedding Assistant w organizacji swojego wielkiego dnia.
            </p>
            <Link to="/register" className="btn btn-primary btn-large">
              Rozpocznij Darmowo
            </Link>
          </div>
        </div>
      </section>

      {/* Stats Section */}
      <section className="stats">
        <div className="container">
          <div className="grid grid-4">
            <div className="stat-item text-center">
              <div className="stat-number">1000+</div>
              <div className="stat-label">Zadowolonych par</div>
            </div>
            <div className="stat-item text-center">
              <div className="stat-number">50+</div>
              <div className="stat-label">Gotowych szablonów</div>
            </div>
            <div className="stat-item text-center">
              <div className="stat-number">24/7</div>
              <div className="stat-label">Wsparcie</div>
            </div>
            <div className="stat-item text-center">
              <div className="stat-number">99%</div>
              <div className="stat-label">Uptime</div>
            </div>
          </div>
        </div>
      </section>
    </div>
  );
};

export default HomePage;
